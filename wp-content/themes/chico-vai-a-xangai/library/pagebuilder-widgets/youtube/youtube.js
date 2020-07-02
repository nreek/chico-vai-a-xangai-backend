(function($){
    $(function(){
        var url = 'https://www.youtube.com/embed/';
        $iframe = $('.js-youtube-channel--iframe');
        var $thumbs = $('.js-youtube-channel--thumbnail');

        $thumbs.on('click', function(e){
            e.preventDefault();
            $iframe.attr('src', url + $(this).data('videoId')+'?autoplay=1');
            $thumbs.removeClass('active');
            $(this).addClass('active');
        });

        $(window).on('resize', function(){
            var h = parseInt($iframe.width() * .5625);
            $iframe.attr('height', h);
        });

        $(window).trigger('resize');
    });
})(jQuery)
