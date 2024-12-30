
let add_room_form = document.getElementById('addRooms_s_form');

add_room_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_rooms();
})

function add_rooms() {
    // Get the data from the form

    let fd = new FormData();
    fd.append('name', add_room_form.elements['room_name'].value);
    fd.append('area', add_room_form.elements['room_area'].value);
    fd.append('price', add_room_form.elements['room_price'].value);
    fd.append('quantity', add_room_form.elements['room_quantity'].value);
    fd.append('adult', add_room_form.elements['room_adult'].value);
    fd.append('children', add_room_form.elements['room_children'].value);
    fd.append('description', add_room_form.elements['room_description'].value);

    let featuresval = [];
    let facilitiesval = [];

    // Loop through the checkboxes for features
    add_room_form.querySelectorAll('input[name="room_feature"]:checked').forEach(element => {
        featuresval.push(element.value);
    });

    // Loop through the checkboxes for facilities
    add_room_form.querySelectorAll('input[name="room_facilities"]:checked').forEach(element => {
        facilitiesval.push(element.value);
    });

    fd.append('features', JSON.stringify(featuresval));
    fd.append('facilities', JSON.stringify(facilitiesval));
    fd.append('add_rooms', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);

    xhr.onload = function() {
        var addRooms_s = document.getElementById('addRooms-s');
        var addRooms_sModelControl = bootstrap.Modal.getInstance(addRooms_s);
        addRooms_sModelControl.hide();

        // Send data to HTML
        if (this.responseText == 1) {
            alertScript('success', "New Room Added Successfully");
            add_room_form.reset();
            get_rooms();
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later");
        }
    }
    xhr.send(fd);
}

function get_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {

        document.getElementById('Room_data').innerHTML = xhr.responseText;

    }
    xhr.send('get_rooms');
}

function toggleStatus(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {

        if (this.responseText == 1) {
            alertScript('success', 'Status Changed Successfully!');
            get_rooms();
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later");
        }

    }
    xhr.send('toggleStatus=' + id + '&value= ' + val);
}



// Edit Room
let editRooms_form = document.getElementById('editRooms_s_form');

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        let data = JSON.parse(this.responseText);
        editRooms_form.elements['room_name'].value = data.roomdata.name;
        editRooms_form.elements['room_area'].value = data.roomdata.area;
        editRooms_form.elements['room_price'].value = data.roomdata.price;
        editRooms_form.elements['room_quantity'].value = data.roomdata.quantity;
        editRooms_form.elements['room_adult'].value = data.roomdata.adult;
        editRooms_form.elements['room_children'].value = data.roomdata.children;
        editRooms_form.elements['room_description'].value = data.roomdata.description;
        editRooms_form.elements['room_id'].value = data.roomdata.sr_no;

        editRooms_form.elements['room_feature'].forEach(el=>{
            if(data.features.includes(Number(el.value))){
                el.checked = true;
            }
        });
        editRooms_form.elements['room_facilities'].forEach(el=>{
            if(data.facilities.includes(Number(el.value))){
                el.checked = true;
            }
        });
    }
    xhr.send('getRoomdetails=' + id);
}

editRooms_form.addEventListener('submit', function(e) {
    e.preventDefault();
    UpdateEdit_rooms();
})

function UpdateEdit_rooms() {
    // Get the data from the form

    let fd = new FormData();
    fd.append('room_id', editRooms_form.elements['room_id'].value);
    fd.append('name',  editRooms_form.elements['room_name'].value);
    fd.append('area',  editRooms_form.elements['room_area'].value);
    fd.append('price',  editRooms_form.elements['room_price'].value);
    fd.append('quantity',  editRooms_form.elements['room_quantity'].value);
    fd.append('adult',  editRooms_form.elements['room_adult'].value);
    fd.append('children',  editRooms_form.elements['room_children'].value);
    fd.append('description',  editRooms_form.elements['room_description'].value);

    let featuresval = [];
    let facilitiesval = [];

    // Loop through the checkboxes for features
     editRooms_form.querySelectorAll('input[name="room_feature"]:checked').forEach(element => {
        featuresval.push(element.value);
    });

    // Loop through the checkboxes for facilities
     editRooms_form.querySelectorAll('input[name="room_facilities"]:checked').forEach(element => {
        facilitiesval.push(element.value);
    });

    fd.append('features', JSON.stringify(featuresval));
    fd.append('facilities', JSON.stringify(facilitiesval));
    fd.append('UpdateEdit_rooms', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);

    xhr.onload = function() {
        var editRooms_s = document.getElementById('editRooms-s');
        var editRooms_sModelControl = bootstrap.Modal.getInstance(editRooms_s);
        editRooms_sModelControl.hide();

        // Send data to HTML
        if (this.responseText == 1) {
            alertScript('success', " Room Updated Successfully");
            editRooms_form.reset();
            get_rooms();
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later");
        }
    }
    xhr.send(fd);
}

window.onload = function() {
    get_rooms();
}
