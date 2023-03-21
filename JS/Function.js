let vault_toggle = true
function cineVault() {
    let doc =document.getElementById('cine-vault')
    vault_toggle = !vault_toggle
    doc.style.display = vault_toggle? 'none': 'block'
}
