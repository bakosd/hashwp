const sliders = document.querySelectorAll(".slider-input input[type='range']");
const minText = document.getElementById('pick-min');
const maxText = document.getElementById('pick-max');
const progress = document.querySelector(".slider-progress");
sliders.forEach(slider =>{
    slider.addEventListener("input", ()=>{
        let minValue = parseInt(sliders[0].value), maxValue = parseInt(sliders[1].value);
        let leftMax = parseInt(sliders[0].max), rightMax = parseInt(sliders[1].max);
        minText.value= minValue;
        maxText.value= maxValue;
        progress.style.left = ((minValue/leftMax) * 50)+ "%";
        progress.style.right = (100 - ((maxValue/rightMax) * 100))+ "%";

    });
});
minText.addEventListener("input", ()=>{
    sliders[0].value = minText.value;
});
maxText.addEventListener("input", ()=> {
    sliders[1].value = maxText.value;
});