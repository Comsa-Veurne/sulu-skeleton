//-- Load SCSS
import './scss/index.scss';

//-- Load modules
import './components/nav';
import './components/video';

//-- masonry
import imagesLoaded from 'imagesloaded';
import Masonry from 'masonry-layout';

//--Lightbox
import GLightbox from 'glightbox';

const images = document.getElementsByClassName('images');
imagesLoaded(document.querySelector('body'), function () {
  const n = images.length;
  for (var i = 0; i < n; i++) {
    new Masonry(images[i], {
      itemSelector: 'div',
      //gutter: 15
    });
  }
});

GLightbox();
