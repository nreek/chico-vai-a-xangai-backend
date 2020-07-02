<?php

$api_key = $instance['youtube_api_key'];
$list_id = $instance['youtube_list_id'];

$num = 4;
if($instance['youtube_list'] == 'playlist'){
    $url = "https://www.googleapis.com/youtube/v3/playlistItems?key={$api_key}&playlistId={$list_id}&maxResults={$num}&part=snippet,id&order=date";
} else if($instance['youtube_list'] == 'channel'){
    $url = "https://www.googleapis.com/youtube/v3/search?key={$api_key}&channelId={$list_id}&maxResults={$num}&part=snippet,id&order=date";
}

$result = json_decode(file_get_contents($url));

if (!is_object($result) || count($result->items) === 0) {
    $result = (object) ['items' => []];
}

$extract_vid = function($video){
    if(isset($video->snippet->resourceId->videoId)){
        return $video->snippet->resourceId->videoId;
    } else if (isset($video->id->videoId)){
        return $video->id->videoId;
    }
};
?>

<div class="row youtube panel">
    
    <div class="col-md-6 pl-0 left">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/play.png" alt="" class="play-icon">
        <h3 class="panel__title mt-3"><?= $instance['title'] ?></h3>
        <h4 class="panel__description"> <?= $instance['description'] ?> </h4>

        <div class="d-flex mt-lg-4 align-items-start">
            <?php if($instance['button_href']): ?>
                <a href="<?= $instance['button_href'] ?>" class="btn btn-primary mr-3" target="<?= $instance['button_external_link'] ? '_blank' : '_self' ?>">
                    <?= ('Ver mais') ?>
                </a>
            <?php endif; ?>
            
            <div class="pt-2">
                <div class="g-ytsubscribe" data-channelid="<?= $instance['youtube_channel_id'] ?>" data-layout="default" data-count="default"></div>
            </div>
        </div>
       
    </div>

    <div class="col-md-6 pl-0">
        <div class="row">
            <iframe class="col-md-12 pl-0 js-youtube-channel--iframe" src="https://www.youtube.com/embed/<?= $extract_vid($result->items[0]) ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

            <div class="column col-md-12 d-flex mt-20 pl-0">
                <?php foreach($result->items as $index => $video): ?>
                    <div class="youtube-chanel--thumbs  <?= $video->snippet->liveBroadcastContent == 'live' ? 'live' : '' ?>">
                        <a href="#" class="youtube-channel--thumbnail js-youtube-channel--thumbnail <?= $index == 0 ? 'active' : '' ?>" data-video-id="<?= $extract_vid($video) ?>" title="<?= htmlentities($video->snippet->title) ?>">
                            <img width="100%" src="<?= $video->snippet->thumbnails->medium->url ?>" >
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        
        </div>
    </div>
</div>
