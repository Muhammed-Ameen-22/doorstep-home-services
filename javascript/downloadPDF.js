var doc = new jsPDF();
// var specialElementHandlers = {
//     '#editor': function (element, renderer) {
//         return true;
//     },
//     '#ignore': function (element, renderer) {
//     return true;
//   }
// };

//margins.left, // x coord   margins.top, { // y coord
function generatePDF() {

  

  var pdf = new jsPDF('p', 'pt', 'a4');
  console.log("This is container",$('.container')[0]);
 pdf.addHTML($('.container')[10], function () 
  { 
     pdf.save('Report.pdf');
     console.log("this is it",pdf);
 });


    //  doc.fromHTML($('.container').html(), 15, 15, {
    //     'width': 700,
    //     'elementHandlers': specialElementHandlers
    // });
   
    // doc.save('sample_file.pdf');
}