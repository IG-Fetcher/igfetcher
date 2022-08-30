<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;

use Instagram\Api;
use Instagram\Exception\InstagramException;
use Instagram\Model\Media;

use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Instagram\Utils\MediaDownloadHelper;


class IgFetcherController extends Controller
{

    const TTL = 24 * 60 * 60; // 24 hours

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    
    public function homepage() {
        return view('home');
    }

    public function userInfosForm(Request $request) {
        $username = $request->input('username');
        // TODO : validate

        $info = $this->getUserInfos($username);
        if (!empty($info) && is_array($info)) {
            return redirect()->route('userinfo.html', [
                'username' => $username
            ]);
        }
        else {
            $error = "No values for this username, either username does not exists or we can't fetch info.";
            return view('home', [
                'error' => $error
            ]);
        }
    }

    public function showUserInfos(Request $request, $username) {
        // Reset cache flag
        $reset_cache = FALSE;

        $query = $request->query();
        if (!empty($query['action']) && !empty($query['token'])) {
            if ($query['action'] == 'purge' && $query['token'] == env('IG_FETCHER_PURGE_TOKEN')) {
                $reset_cache = TRUE;
            }
        }

        // Get info, from cache or upstream
        $info = $this->getUserInfos($username, $reset_cache);
        if (!empty($info) && is_array($info)) {
            return view('userinfo', [
                'username' => $username,
                'info' => $info
            ]);
        }
        else {
            $error = "No values for this username.";
            return redirect()->route('homepage', [
                'error' => $error
            ]);
        }
    }

    public function showUserInfosJSON($username) {
        $info = $this->getUserInfos($username);
        return response()->json($info);
    }

    protected function getUserInfos($username, $reset_cache = FALSE) {
        $info = NULL;
        if (!$reset_cache && Cache::has('user_' . $username)) {
            // Get from cache
            $info = Cache::get('user_' . $username, NULL);
        }
        else {
            if ($reset_cache) {
                Cache::forget('user_' . $username);
            }
            // Fetch from upstream
            $info = $this->fetchUserInfos($username);
        }
        return $info;
    }

    protected function fetchUserInfos($username) {
        $info = NULL;

        // Get credentials
        $account = $this->getIgAccount();
        $password = $this->getIgPassword();
        if (empty($account) || empty($password)) {
            die("Please provide an Instagram account name & password");
        }

        // Fetch info
        $cachePool = new FilesystemAdapter('IGFetcher');
        try {
            $api = new Api($cachePool);
            $api->login($account, $password);

            $profile = $api->getProfile($username);
            $medias = $profile->getMedias();

            // download thumbnail locally because upstream prevent hotlinking
            // storage_path('public') ?
            $download_path = base_path('public') . '/thumbnails/' . $username;
            if (!is_dir($download_path)) {
                mkdir($download_path, 0775, true);
            }

            // Store profile picture locally
            $profile_picture_cached_filename = $this->downloadThumbnail($profile->getProfilePicture(), $download_path);
            $profile_picture_cached = env('APP_URL') . '/thumbnails/' . $username . '/' . $profile_picture_cached_filename;

            // Medias
            $clean_medias = [];
            foreach ($medias as $key => $media) {

                $thumbnail_cached_filename = $this->downloadThumbnail($media->getThumbnailSrc(), $download_path);
                $thumbnail_cached = env('APP_URL') . '/thumbnails/' . $username . '/' . $thumbnail_cached_filename;

                $clean_medias[$key] = [
                    'id' => $media->getId(),
                    'date' => $media->getDate()->format('Y-m-d h:i:s'),
                    'datetime' => $media->getDate(),
                    'caption' => $media->getCaption(),
                    'link' => $media->getLink(),
                    'thumbnail' => $media->getThumbnailSrc(),
                    'thumbnail_cached' => $thumbnail_cached,
                ];
            }

            $info = [
                'username' => $username,
                'fullname' => $profile->getFullName(),
                'biography' => $profile->getBiography(),
                'external_url' => $profile->getExternalUrl(),
                'profile_picture' => $profile_picture_cached,
                'followers' => $profile->getFollowers(),
                'following' => $profile->getFollowing(),
                'private' => $profile->isPrivate(),
                'medias' => $clean_medias,
            ];

            // Store in cache
            Cache::add('user_'.$username, $info, self::TTL);

            // Return values
            return $info;

        } catch (InstagramException $e) {
            // die($e->getMessage());
            return redirect()->route('homepage', [
                'error' => $e->getMessage()
            ]);
        } catch (CacheException $e) {
            // die($e->getMessage());
            return redirect()->route('homepage', [
                'error' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            // die($e->getMessage());
            return redirect()->route('homepage', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function downloadThumbnail($url, $download_path) {
        // From https://github.com/pgrimaud/instagram-user-feed/blob/master/src/Instagram/Utils/MediaDownloadHelper.php
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $fileName = substr(str_replace('/', '-', parse_url($url, PHP_URL_PATH)), 1);
            $content = file_get_contents($url);
            file_put_contents($download_path . '/' . $fileName, $content);

            return $fileName;
        }
    }


    private function getIgAccount() {
        return env('INSTAGRAM_ACCOUNT');
    }

    private function getIgPassword() {
        return env('INSTAGRAM_PASSWORD');
    }


    public function debug($value) {
        print '<pre>'.print_r($value, true) . '</pre>';
    }
}
