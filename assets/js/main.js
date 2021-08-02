const toggleButton = document.getElementById('toggle-button');
const toggleContent = document.getElementById('sidebar-content');

toggleButton.addEventListener('click', () => {
	document.body.classList.toggle('active');
	toggleContent.classList.toggle('active');
});
