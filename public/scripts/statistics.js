// import { jsPDF } from "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js";
const doc = new jsPDF();
document.querySelector('.stats-header h5').addEventListener('click', async function (event) {


    doc.text("Hello world!", 10, 10);
    doc.save("a4.pdf");
});