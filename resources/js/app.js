import './bootstrap';

// Add keyboard shortcut for command palette
document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        Livewire.dispatch('toggle-global-search');
    }
});
