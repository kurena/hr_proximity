setTimeout(() => {
  $(document).ready( function () {
    $('#approvedPermissions, #requestedPermissions, #contracts-dashboard, #requestedVacations, #approvedVacations, #incapacity-view, #travel-expense, #employeeData').DataTable( {
    scrollY:        '50vh',
    scrollCollapse: true,
    language: {
        "url": "/json/dataTables.spanish.lang"
    },
    responsive: {
        details: {
            renderer: function ( api, rowIdx, columns ) {
                var data = $.map( columns, function ( col, i ) {
                    return col.hidden ?
                        '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                            '<td>'+col.title+':'+'</td> '+
                            '<td>'+col.data+'</td>'+
                        '</tr>' :
                        '';
                } ).join('');

                return data ?
                    $('<table/>').append( data ) :
                    false;
            }
        }
    } 
    });
  });  
}, 100);