function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Tutup modal saat mengklik di luar modal
window.onclick = function(event) {
    let modal = document.getElementsByClassName("modal");
    for (let i = 0; i < modal.length; i++) {
        if (event.target == modal[i]) {
            closeModal(modal[i].id);
        }
    }
}
