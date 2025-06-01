<form method="POST" action="{{ route('contact.admin') }}">
    @csrf {{-- Laravel's CSRF token for security --}}

    <div>
        <label for="subject">Assunto:</label>
        <input type="text" id="subject" name="subject" required>
    </div>

    <div>
        <label for="message">Mensagem:</label>
        <textarea id="message" name="message" rows="5" required></textarea>
    </div>

    <button type="submit">Enviar Mensagem</button>
</form>
