<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function alertScript(type,msg,position='body') {
        let el = document.createElement('div');
        el.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show " role="alert">
              <strong class="me-3">${msg}</strong>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>`;
           if (position=='body') {
               document.body.append(el);
               el.classList.add('custom-alert');
           }else{
            document.getElementById(position).appendChild(el);
           }
           setTimeout(delAlert,2000);
    }
    function delAlert(){
        document.getElementsByClassName('alert')[0].remove();
    }
    function setactive() {
    let filename = location.pathname.split('/').pop().split('.')[0];
    let a_tags = document.querySelectorAll('#dashboard-menu a');

    a_tags.forEach(tag => {
        if (tag.href.includes(filename)) {
            tag.classList.add('active');
        }
    });
}

setactive();

</script>