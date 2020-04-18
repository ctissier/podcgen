<?php
    //Version 1.0
    //2020-04-18
    //Author : Clément TISSIER - https://github.com/ctissier

    require_once('vendor/id3/ID3TagsReader.php');

    /** CONFIGURATION */
    $podcastInfo = [
        'title' => "My Podcast",
        'subtitle' => "Podcast about...",
        'description' => "This is the description of my podcast",
        'link' => "https://mydoma.in/podcast",
        'language' => 'fr-fr',
        'copyright' => 'Copyright myCopyright 2001',
        'webmaster_mail' => 'user@mydoma.in',
        'author' => 'Jane Doe',
        'owner_name' => 'Jane Doe',
        'owner_mail' => 'owner@mydoma.in',
        'explicit_content' => 'no', //yes or no
        'rating' => 'TV-G',
        'location' => 'Paris, France',
        'frequency' => 'monthly',
        'category' => 'Podcast',
        'keywords' => 'comma,separated,keywords',
    ];

    /** THERE'S NO REASON TO CHANGE THE FOLLOWING TWO LINES, BUT, IF YOU KNOW WHAT YOU'RE DOING **/
    $filesFolder = '/files/';
    $xmlFileName = 'index.xml';

    /** DO NOT EDIT BELOW THIS, UNLESS YOU KNOW WHAT YOU'RE DOING */
    $id3Reader = new ID3TagsReader(null);
    //$id3Info = $id3Reader->getTagsInfo(__DIR__.$filesFolder.'test.mp3');

    ob_start();
?>

    <rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:rawvoice="http://www.rawvoice.com/rawvoiceRssModule/" version="2.0">

    <channel>
        <title><?php echo $podcastInfo['title']; ?></title>
        <link><?php echo $podcastInfo['link'].'/'.$xmlFileName; ?></link>

        <image>
            <url><?php echo $podcastInfo['link'].'/image.jpg'; ?></url>
            <title><?php echo $podcastInfo['title']; ?></title>
            <link><?php echo $podcastInfo['link']; ?></link>
        </image>

        <description>
            <?php echo $podcastInfo['description']; ?>
        </description>
        <language><?php echo $podcastInfo['language']; ?></language>
        <copyright><?php echo $podcastInfo['copyright']; ?></copyright>
        <atom:link href="https://podcasts.thepolyglotdeveloper.com/podcast.xml" rel="self" type="application/rss+xml"/>
        <lastBuildDate><?php echo date('r'); ?></lastBuildDate>
        <itunes:author><?php echo $podcastInfo['author']; ?></itunes:author>
        <itunes:summary>
            <?php echo $podcastInfo['description']; ?>
        </itunes:summary>
        <itunes:subtitle><?php echo $podcastInfo['subtitle']; ?></itunes:subtitle>
        <itunes:owner>
            <itunes:name><?php echo $podcastInfo['owner_name']; ?></itunes:name>
            <itunes:email><?php echo $podcastInfo['owner_mail']; ?></itunes:email>
        </itunes:owner>
        <itunes:explicit><?php echo $podcastInfo['explicit_content']; ?></itunes:explicit>
        <itunes:keywords>
            <?php echo $podcastInfo['keywords']; ?>
        </itunes:keywords>
        <itunes:image href="<?php echo $podcastInfo['link'].'/image.jpg'; ?>"/>
        <rawvoice:rating><?php echo $podcastInfo['rating']; ?></rawvoice:rating>
        <rawvoice:location><?php echo $podcastInfo['location']; ?></rawvoice:location>
        <rawvoice:frequency><?php echo $podcastInfo['frequency']; ?></rawvoice:frequency>
        <itunes:category text="<?php echo $podcastInfo['category']; ?>"/>


        <?php
            $dir = __DIR__.'/public/'.$filesFolder;
            if ($handle = opendir($dir)) {
                while (false !== ($entry = readdir($handle))) {
                    if(is_file($dir.$entry) && !is_dir($dir.$entry) && mime_content_type($dir.$entry) == 'audio/mpeg'){


                        $baseUrl = $podcastInfo['link'].$filesFolder;
                        $fileId3Info = $id3Reader->getTagsInfo($dir.$entry);
                        ?>
                        <item>
                            <title><![CDATA[<?php echo $fileId3Info['Title'] ?>]]></title>
                            <link><?php echo $baseUrl.$entry; ?></link>
                            <guid><?php echo $baseUrl.$entry; ?></guid>
                            <description><![CDATA[<?php echo $fileId3Info['Title'] ?>]]></description>
                            <enclosure url="<?php echo $baseUrl.'/files/'.$entry ?>" length="<?php echo filesize($dir.$entry) ?>" type="audio/mpeg"/>
                            <category><![CDATA[<?php echo $fileId3Info['Genre'] ?>]]></category>
                            <pubDate><?php echo date('r'); ?></pubDate>

                            <itunes:duration><?php echo $fileId3Info['Lenght']; ?></itunes:duration>
                            <itunes:summary>
                                <![CDATA[<?php echo $fileId3Info['Title'] ?>]]>
                            </itunes:summary>
                            <itunes:image href="http://www.example.com/image3000x3000.png"/>
                            <itunes:explicit><?php echo $podcastInfo['explicit_content']; ?></itunes:explicit>
                        </item>
                        <?php
                    }
                }
                closedir($handle);
            }
        ?>

    </channel>
</rss>

<?php
    $str = ob_get_clean();
    $str = '<?xml version="1.0" encoding="UTF-8"?>'.$str;

    file_put_contents(__DIR__.'/public/'.$xmlFileName,$str);

    echo 'OK : ' . __DIR__.'/'.$xmlFileName;
