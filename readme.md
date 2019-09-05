Run 

`composer require frosinas/unsplash` to install the package

Run 

`php artisan vendor:publish --tag=Frosinas\Unsplash\UnsplashProvider` to publish the provider settings


add following variables to your config



UNSPLASH_CLIENT_ID=your client
UNSPLASH_CLIENT_SECRET=your secret
UNSPLASH_REDIRECT_URL=http://localhost:8000/api/unsplash/authorization (this should be added to Redirect URI inside your Unsplash app)
UNSPLASH_API_URL=https://unsplash.com/
