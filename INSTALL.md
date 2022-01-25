# Install IG-Fetcher

Run the following commands :

    # Clone the source code
    $ git clone https://github.com/IG-Fetcher/igfetcher.git
    
    # Install PHP dependencies
    $ composer install

    # Create & configure folders
    $ (sudo) chgrp -R www-data cache
    $ (sudo) chmod -R ug+rwx cache

    $ (sudo) chgrp -R www-data storage
    $ (sudo) chmod -R ug+rwx storage

    $ (sudo) chgrp -R www-data public/thumbnails
    $ (sudo) chmod -R ug+rwx public/thumbnails


Create your secret configuration file by copying the `.env.example` file to a `.env` file, and edit the latter to update your configuration and fill your Instagram credentials.

