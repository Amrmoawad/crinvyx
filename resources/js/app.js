import './bootstrap';
import './form-submit-guard';
import flatpickr from 'flatpickr';
import TomSelect from 'tom-select';
import '../../vendor/power-components/livewire-powergrid/resources/js/powergrid';

window.flatpickr = flatpickr;
window.TomSelect = TomSelect;

document.addEventListener('input', (event) => {
    if (event.target instanceof HTMLInputElement && event.target.classList.contains('integer-only')) {
        event.target.value = event.target.value.replace(/[^0-9]/g, '');
    }
});
