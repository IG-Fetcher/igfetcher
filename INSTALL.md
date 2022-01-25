# Install IG-Fetcher

Make sure you have PHP installed with the following extensions :

- php-mbstring
- php-curl
- php-xml
- php-zip

You should have [Composer](https://getcomposer.org/download/) installed too in order to manage dependencies.

Run the following commands :

    # Clone the source code
    $ git clone https://github.com/IG-Fetcher/igfetcher.git
    $ cd igfetcher
    
    # Install PHP dependencies
    $ composer install

    # Create & configure folders
    $ (sudo) chgrp -R www-data storage public/thumbnails
    $ (sudo) chmod -R ug+rwx storage public/thumbnails


Create your secret configuration file by copying the `.env.example` file to a `.env` file, and edit the latter to update your configuration and fill your Instagram credentials.

