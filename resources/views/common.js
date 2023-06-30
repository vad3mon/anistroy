const LOCATION = { center: [37.623082, 55.75254], zoom: 9 };
const NEW_LOCATION = { center: [42.623082, 57.75254], zoom: 7 };

function rangeRandom(min, max) {
    return (max - min) * Math.random() + min;
}

let lock = false;
const onMouseDown = (e) => {
    lock = true;
};
const onMouseUp = (e) => {
    lock = false;
};

window.addEventListener('mousedown', onMouseDown);
window.addEventListener('mouseup', onMouseUp);

