# Light PHP audio podcast xml file generator

## Purpose
If you have some audio files you want to publish as a podcast, that little script will simply generate the xml file that podcast apps (such as Downcast) can read.

It doesn't replace a fully featured podcast manager app, but it can be usefull if you only want to generate a podcast from .mp3 files.

I developed it to regenerate public podcasts for which I had .mp3 files archive but for which owners removed podcast feeds.

The use is simple: just put some .mp3 files in the `public/files/` folder, edit the configuration variables in the `generate.php` file, execute it and upload the `public/` folder's content on your server through FTP or directly to a public Google Drive/Dropbox/OneDrive/etc. folder.

It extracts the data from each `.mp3` file to generate the XML metadata.

## Installation & Configuration
You don't really need to install. Just download the entire project. You'll find :

* A `public` folder having the data you want to make public (audio files, illustration image, etc.)
* A `vendor` with external dependencies
* A `generate.php` script that generates the `public/index.xml` file from the .mp3 files you'll put in the `public/files/` folder

There are two ways of using this script:

1. (Recommended) You can execute it locally and only upload the `public` folder's content to a web server (or Goodle Drive/Dropbox/Onedrive/... public folder) or
2. You can upload all the project and generate the xml file online.

### First way: Local execution of the script and upload of the public folder's content (Recommended)

**Update the configuration**

In the `generate.php` script file, change at least the value of the `$podcastUrl` variable with the url at which your podcast will be reachable.
This is the url where you will upload the `index.xml` file and `files` folder.

For example, if you upload the podcast at `https://mydomaine.com/podcasts` so that the `index.xml` ìs reachable at `https://mydomaine.com/podcasts/index.xml`, just put `https://mydomaine.com/podcasts` as a value of the $podcastUrl` variable.

You'll also want to adjust the `$podcastInfo` variable to suit your podcast info.


**Generate the `public/index.xml` file**

To generate the podcast `index.xml` file, just execute the `generate.php` script locally

> `> php generate.php`

It will search the `public/files/` folder for files with `audio/mpeg` mime type, extract data from the [ID3 tags](https://fr.wikipedia.org/wiki/ID3_(m%C3%A9tadonn%C3%A9es_MP3)) and generate a `index.xml` in the `public/` folder.


**Upload the content of the `public/` folder**

You just need to upload the **content** of the `public` folder to your server and access the url with your podcast app.


### Second way: Online execution of the script
TODO


## DISCLAIMER
This script is provided as is.

If you intend to publicly distribute the url of your podcast, be sure to have the right to do so with the .mp3 file you share/publish.


## TODO
There are many things left to do, such as :
- Finish this readme file
- Support the encoding (utf-8, ISO, etc.) of the ID3 Tags
- Support a different illustration for each .mp3 file
- Support of video podcasts
- ...

## LICENSE
GPLv3