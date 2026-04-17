const colors = [
    {name: "Black", value: 0, color: "#000000", multiplier: 1, tolerance: null, tempCoeff: 250},
    {name: "Brown", value: 1, color: "#8B4513", multiplier: 10, tolerance: 1, tempCoeff: 100},
    {name: "Red", value: 2, color: "#FF0000", multiplier: 100, tolerance: 2, tempCoeff: 50},
    {name: "Orange", value: 3, color: "#FF6600", multiplier: 1000, tolerance: null, tempCoeff: 15},
    {name: "Yellow", value: 4, color: "#FFFF00", multiplier: 10000, tolerance: null, tempCoeff: 25},
    {name: "Green", value: 5, color: "#008000", multiplier: 100000, tolerance: 0.5, tempCoeff: null},
    {name: "Blue", value: 6, color: "#3300CC", multiplier: 1000000, tolerance: 0.25, tempCoeff: 10},
    {name: "Violet", value: 7, color: "#CC00FF", multiplier: 10000000, tolerance: 0.1, tempCoeff: 5},
    {name: "Gray", value: 8, color: "#808080", multiplier: 100000000, tolerance: 0.05, tempCoeff: null},
    {name: "White", value: 9, color: "#FFFFFF", multiplier: 1000000000, tolerance: null, tempCoeff: null},
    {name: "Gold", value: null, color: "#FFD700", multiplier: 0.1, tolerance: 5, tempCoeff: null},
    {name: "Silver", value: null, color: "#C0C0C0", multiplier: 0.01, tolerance: 10, tempCoeff: null}
];

function populateColorOptions() {
    const bandSelectors = ["band1", "band2", "band3"];
    const colorSelectors = document.querySelectorAll("select");

    colorSelectors.forEach(selector => {
        let allowedColors;
        if (selector.id === "tolerance") {
            allowedColors = colors.filter(color => ["Brown", "Red", "Green", "Blue", "Violet", "Gray", "Gold", "Silver"].includes(color.name));
        } else if (selector.id === "tempCoeff") {
            allowedColors = colors.filter(color => ["Brown", "Red", "Orange", "Yellow", "Blue", "Violet"].includes(color.name));
        } else if (bandSelectors.includes(selector.id)) {
            allowedColors = colors.filter(color => !["Gold", "Silver"].includes(color.name));
        } else {
            allowedColors = colors;
        }

        allowedColors.forEach(color => {
            let option = document.createElement("option");
            option.value = color.name;
            option.text = color.name;
            selector.appendChild(option);
        });
    });
}

function selectBand(bands) {
    document.querySelectorAll(".tab-button").forEach((btn, index) => {
        btn.classList.toggle("active", index === bands - 4);
    });

    document.getElementById("band3Container").style.display = bands >= 5 ? "block" : "none";
    document.getElementById("tempCoeffContainer").style.display = bands === 6 ? "block" : "none";

    calculateResistor();
}

function calculateResistor() {
    const band1 = colors.find(color => color.name === document.getElementById("band1").value);
    const band2 = colors.find(color => color.name === document.getElementById("band2").value);
    const band3 = document.getElementById("band3Container").style.display !== "none" ? colors.find(color => color.name === document.getElementById("band3").value) : null;
    const multiplier = colors.find(color => color.name === document.getElementById("multiplier").value);
    const tolerance = colors.find(color => color.name === document.getElementById("tolerance").value);
    const tempCoeff = document.getElementById("tempCoeffContainer").style.display !== "none" ? colors.find(color => color.name === document.getElementById("tempCoeff").value) : null;

    const value = parseInt(band1.value.toString() + band2.value.toString() + (band3 ? band3.value.toString() : ''));
    let resistance = value * multiplier.multiplier;

    let unit = "Ω";
    if (resistance >= 1000) {
        resistance /= 1000;
        unit = "kΩ";
    }

    const toleranceStr = tolerance ? `±${tolerance.tolerance}%` : "";
    const tempCoeffStr = tempCoeff ? `${tempCoeff.tempCoeff} ppm/°C` : "";

    document.getElementById("resistorValue").innerText = `${resistance} ${unit} ${toleranceStr} ${tempCoeffStr}`;

    drawResistor(band1.color, band2.color, band3 ? band3.color : null, multiplier.color, tolerance.color, tempCoeff ? tempCoeff.color : null);
}

function drawResistor(color1, color2, color3, colorMultiplier, colorTolerance, colorTempCoeff = null) {
    const canvas = document.getElementById("resistorImage");
    const ctx = canvas.getContext("2d");

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = "#D3D3D3";
    ctx.fillRect(50, 40, 200, 60);
    ctx.strokeRect(50, 40, 200, 60);

    [color1, color2, color3, colorMultiplier, colorTolerance, colorTempCoeff].forEach((color, index) => {
        if (color) drawBand(ctx, 60 + index * 30, color);
    });
}

function drawBand(ctx, position, color) {
    ctx.fillStyle = color;
    ctx.fillRect(position, 40, 15, 60);
}

window.onload = function() {
    populateColorOptions();
    selectBand(4);
}
