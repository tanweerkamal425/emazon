let qtyInput = document.querySelector('#qty-input');
let btn1 = document.querySelector('qty-incr-btn');
let btn2 = document.querySelector('qty-dcr-btn');
btn1.addEventListener('click', (event) => {
    console.log('btn clicked');
});
btn2.addEventListener('click', (event) => {
    qtyInput.value += 1;
})