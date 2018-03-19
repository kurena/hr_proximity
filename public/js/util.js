setTimeout(() => {
  $(document).ready( function () {
    $('#employeeData').DataTable( {
      "language": {
        "url": "/json/dataTables.spanish.lang"
      }
    });
  });  
}, 100);