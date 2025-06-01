<x-app-layout>
<div class="container text-center mt-5">
    <h3>Redirecionando para o PayPal...</h3>
    <p>Por favor, aguarde.</p>
</div>

<script>
    setTimeout(() => {
        window.location.href = "{{ $paypalUrl }}";
    }, 2000);
</script>
</x-app-layout>
