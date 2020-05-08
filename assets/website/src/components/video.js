document.querySelectorAll('.youtube-player').forEach(youtubePlayer => {
  let youtubeId = youtubePlayer.dataset.id;
  let thumbnail = createThumbnail(youtubeId);

  youtubePlayer.appendChild(thumbnail);
});

function createThumbnail(id) {
  let thumbnail = document.createElement('div');
  let thumb = document.createElement('img');
  thumb.setAttribute('src', 'https://i.ytimg.com/vi/' + id + '/hqdefault.jpg');
  thumbnail.appendChild(thumb);

  let play = document.createElement('div');
  play.setAttribute('class', 'play');
  thumbnail.appendChild(play);

  thumbnail.dataset.id = id;
  thumbnail.onclick = createIframe;
  return thumbnail;
}

function createIframe(e) {
  e.preventDefault();
  e.stopPropagation();
  let thumbnail = e.target;
  let id = thumbnail.dataset.id;

  //-- Is the API loaded already?
  let youtubeApiSrc = "https://www.youtube.com/player_api";
  let youtubeApiScript = document.querySelector('script[src="' + youtubeApiSrc + '"]');
  if (!youtubeApiScript) {
    let tag = document.createElement('script');
    tag.src = youtubeApiSrc;
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }

  window.onYouTubeIframeAPIReady = () => {
    new YT.Player(thumbnail, {
      playerVars: {
        autoplay: 1,
        controls: 0,
        disablekb: 1,
        loop: 1,
        modestbranding: 1,
        mute: 0,
        rel:0,
        playlist: id
      },
      videoId: id
    })
  }
}
