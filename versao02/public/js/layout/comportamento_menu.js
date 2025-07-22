document.getElementById('menuCadastros').addEventListener('mouseover', function() {
    const menuFlutCadastro = document.createElement('div');
    menuFlutCadastro.className = 'menuFlutCadastro';
    menuFlutCadastro.id = 'menuFlutCadastro';
    this.appendChild(menuFlutCadastro);
})
document.getElementById('menuCadastros').addEventListener('mouseout', function() {
    const menuFlutCadastro = document.getElementById('menuFlutCadastro');
    menuFlutCadastro.remove();
})