

const wrapper = document.querySelector('.preloader')
const page = document.querySelector('body')

window.setTimeout(preloaderFunction, 2000)

function preloaderFunction() {
    wrapper.style.display = 'none';
    page.style.overflowY = 'auto';
}


var tl = new TimelineMax({
    repeat: -1
  });
  
  tl.add(
    TweenMax.from(".preloader-logo", 2, {
      scale: 0.5,
      rotation: 360,
      ease: Elastic.easeInOut
    })
  );  
  tl.add(
    TweenMax.to(".preloader-logo", 2, {
      scale: 0.5,
      rotation: 360,
      ease: Elastic.easeInOut
    })
  );

history.scrollRestoration = 'manual';
