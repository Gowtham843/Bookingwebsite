let add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
});


function add_image() {

    let fd = new FormData();

    fd.append('image', add_image_form.elements['image'].files[0]);
    fd.append('room_id', add_image_form.elements['room_id'].value);
    fd.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true)


    xhr.onload = function () {
        //    send data to html
        if (this.responseText == 'inv_img') {
            alertScript('danger', "Error...!, Invalid Image Formate", 'image_alert');

        } else if (this.responseText == 'Image_size_is_more') {
            alertScript('danger', "Error...!, Image Size is more than allowed", 'image_alert');

        } else if (this.responseText == 'Error_in_Uploading_the_file') {
            alertScript('danger', "Error...!, Server Error,Please try later", 'image_alert');

        } else if (this.responseText == '1') {
            alertScript('success', "Image Successfully Saved", 'image_alert');
            room_image(add_image_form.elements['room_id'].value, document.getElementById('room_title').innerText)
            add_image_form.reset();
        }
    }
    xhr.send(fd);

}

function room_image(id, rname) {
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';
    document.getElementById('room_title').innerText = rname;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room_image_data').innerHTML = this.responseText

    }
    xhr.send('room_image=' + id);
}

function delete_image(img_id, room_id) {
    let fd = new FormData();

    fd.append('image_id', img_id);
    fd.append('room_id', room_id);
    fd.append('delete_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true)


    xhr.onload = function () {
        //    send data to html
        if (this.responseText == '1') {
            alertScript('success', "Image Successfully Delete", 'image_alert');
            room_image(room_id, document.getElementById('room_title').innerText)
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later", 'image_alert');

        }
    }
    xhr.send(fd);


}
function thumb_image(img_id, room_id) {
    let fd = new FormData();

    fd.append('image_id', img_id);
    fd.append('room_id', room_id);
    fd.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms_settings.php", true)


    xhr.onload = function () {
        //    send data to html
        if (this.responseText == '1') {
            alertScript('success', "Image Thumbnail Successfully Changed", 'image_alert');
            room_image(room_id, document.getElementById('room_title').innerText)
        } else {
            alertScript('danger', "Error...!, Server Error,Please try later", 'image_alert');

        }
    }
    xhr.send(fd);


}
function delete_room_image(room_id) {

    if (confirm("Are you sure you want to delete this room")) {
        let fd = new FormData();
        fd.append('room_id', room_id);
        fd.append('delete_room_image', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms_settings.php", true)


        xhr.onload = function () {
            //    send data to html
            if (this.responseText == '1') {
                alertScript('success', "Room Successfully Delete");
                get_rooms();
            } else {
                alertScript('danger', "Error...!, Server Error,Please try later");

            }
        }
        xhr.send(fd);
    }

}