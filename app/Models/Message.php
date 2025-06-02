<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt; // Import the Crypt facade

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    // Define relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Mutator: Encrypt the message body before saving to the database.
     * This method is automatically called when you set the 'body' attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setBodyAttribute($value)
    {
        // Only encrypt if the value is not null and not already encrypted (e.g., if re-saving an existing encrypted message)
        if ($value !== null && $value !== '') {
            $this->attributes['body'] = Crypt::encryptString($value);
        } else {
            $this->attributes['body'] = null; // Store null if empty
        }
    }

    /**
     * Accessor: Decrypt the message body when retrieving it from the database.
     * This method is automatically called when you access the 'body' attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getBodyAttribute($value)
    {
        // Only decrypt if the value is not null and not already plaintext (e.g., if handling old plaintext messages)
        // Crypt::decryptString throws an error if input is not encrypted or corrupt.
        // A try-catch block is good practice here.
        try {
            if ($value !== null && $value !== '') {
                return Crypt::decryptString($value);
            }
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Log the error or return a placeholder if decryption fails
            // For example, if you have old unencrypted messages
            \Log::error("Decryption failed for message ID: " . $this->id . ". Error: " . $e->getMessage());
            return '[Mensagem encriptada ilegível]'; // Or just return the raw encrypted value for debugging
        }

        return $value; // Return the value as is if it's null or empty
    }

    // You can apply similar logic for the 'subject' if it's also sensitive
    public function setSubjectAttribute($value)
    {
        if ($value !== null && $value !== '') {
            $this->attributes['subject'] = Crypt::encryptString($value);
        } else {
            $this->attributes['subject'] = null;
        }
    }

    public function getSubjectAttribute($value)
    {
        try {
            if ($value !== null && $value !== '') {
                return Crypt::decryptString($value);
            }
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            \Log::error("Decryption failed for subject of message ID: " . $this->id . ". Error: " . $e->getMessage());
            return '[Assunto encriptado ilegível]';
        }
        return $value;
    }
}
