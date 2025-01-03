document.getElementById("downloadPdf").addEventListener("click", function (event) {
   event.preventDefault();
   pdfName = this.getAttribute("pdfName") + ".pdf";
   const element = document.querySelector('.container_dashboard');
   const tempContainer = document.createElement('div');
   tempContainer.innerHTML = element.innerHTML;

   tempContainer.querySelectorAll('*').forEach(node => {
      node.removeAttribute('class');
      node.removeAttribute('style');
      if (node.tagName === 'H1' || node.tagName === 'H2' || node.tagName === 'H3' || node.tagName === 'H4') {
         node.setAttribute('style', 'font-size: 10px; font-family: Arial, sans-serif; color: black; margin: 0; padding: 0 0.5rem; line-height: 2; ');
      }
      if (node.tagName === 'P') {
         node.setAttribute('style', 'font-size: 8px; font-family: Arial, sans-serif; color: black; margin: 0; padding: 0 0.5rem; line-height: 1.5; text-align: justify');
      }
      if (node.tagName === 'IMG') {
         node.setAttribute('style', 'width: 20%; max-width: 200px; margin: 0; padding: 0 0.5rem;');
      }
   });

   const options = {
      margin: 15,
      filename: pdfName,
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: {
         scale: 3
      },
      jsPDF: {
         unit: 'mm',
         format: 'a4',
         orientation: 'portrait'
      }
   };

   html2pdf().set(options).from(tempContainer).save();
});