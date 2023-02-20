$(document).ready(function () {
    $('#myTable').DataTable();
});

edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName('td')[1].innerText;
        description = tr.getElementsByTagName('td')[2].innerText;
        titleEdit.value = title;
        descriptionEdit.value = description;
        idEdit.value = e.target.id;
        $("#editModal").modal('toggle');
        // Id identifier is used to insert the value, check modal;
    });
});

del = document.getElementsByClassName('del');
Array.from(del).forEach((element)=>{
    element.addEventListener("click",(e)=>{
        idDel = e.target.id;
        if(confirm("Press Button")){
            console.log("yes");
            window.location = `notePad.php?id=${idDel}`;
        }else{
            console.log("No");
        }
        // Id identifier is used to insert the value, check modal;
    });
});
