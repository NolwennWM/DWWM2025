import Slider from "./Slider.js";

const slider1 = new Slider("slider-container-1");
const imagePaths1 = [
  "images/chien.jpg",
  "images/montagne.jpg",
  "images/ordi.jpg",
];
slider1.initSlider(imagePaths1, 3000);
slider1.startSlider();

const slider2 = new Slider("slider-container-2");
const imagePaths2 = [
  "images/chien.jpg",
  "images/montagne.jpg",
  "images/ordi.jpg",
];
slider2.initSlider(imagePaths2, 5000);
slider2.startSlider();

const slider3 = new Slider("slider-container-3");
const imagePaths3 = [
  "images/chien.jpg",
  "images/montagne.jpg",
  "images/ordi.jpg",
];
slider3.initSlider(imagePaths3, 3000);
slider3.startSlider();