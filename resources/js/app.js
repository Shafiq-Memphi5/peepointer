import './bootstrap';

axios.post('/send-otp', {
    email: 'example@example.com'
}, {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
});
