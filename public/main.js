// starting after html is loaded
document.addEventListener('DOMContentLoaded', function () {
   const sliderBtnLeft = document.querySelector('#sliderBtnLeft');
   const sliderBtnRight = document.querySelector('#sliderBtnRight');

   sliderBtnLeft.addEventListener('click', function () {
      console.log('left');
   });
   sliderBtnRight.addEventListener('click', function () {
      console.log('left');
   });

});
