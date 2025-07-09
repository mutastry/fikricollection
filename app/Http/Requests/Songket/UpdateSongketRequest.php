<?php

namespace App\Http\Requests\Songket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSongketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->canAccess('manage_songkets');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'       => 'required|exists:categories,id',
            'name'              => 'required|string|max:255',
            'description'       => 'required|string|min:10',
            'base_price'        => 'required|numeric|min:1000',
            'colors'            => 'nullable|array|min:1',
            'colors.*'          => 'required|string|max:50',
            'images'            => 'nullable|array|max:5',
            'images.*'          => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'stock_quantity'    => 'required|integer|min:0',
            'is_featured'       => 'boolean',
            'is_active'         => 'boolean',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required'      => 'Kategori songket harus dipilih.',
            'category_id.exists'        => 'Kategori yang dipilih tidak valid.',
            'name.required'             => 'Nama songket harus diisi.',
            'name.string'               => 'Nama songket harus berupa teks.',
            'name.max'                  => 'Nama songket tidak boleh lebih dari 255 karakter.',
            'description.required'      => 'Deskripsi songket harus diisi.',
            'description.string'        => 'Deskripsi songket harus berupa teks.',
            'description.min'           => 'Deskripsi songket minimal 10 karakter.',
            'base_price.required'       => 'Harga songket harus diisi.',
            'base_price.numeric'        => 'Harga songket harus berupa angka.',
            'base_price.min'            => 'Harga songket minimal Rp 1.000.',
            'colors.array'              => 'Warna songket harus berupa daftar.',
            'colors.min'                => 'Minimal harus ada 1 pilihan warna.',
            'colors.*.required'         => 'Nama warna tidak boleh kosong.',
            'colors.*.string'           => 'Nama warna harus berupa teks.',
            'colors.*.max'              => 'Nama warna tidak boleh lebih dari 50 karakter.',
            'images.array'              => 'Gambar songket harus berupa daftar.',
            'images.max'                => 'Maksimal 5 gambar yang dapat diunggah.',
            'images.*.image'            => 'File yang diunggah harus berupa gambar.',
            'images.*.mimes'            => 'Format gambar harus JPEG, PNG, JPG, atau WebP.',
            'images.*.max'              => 'Ukuran gambar maksimal 2MB.',
            'stock_quantity.required'   => 'Jumlah stok harus diisi.',
            'stock_quantity.integer'    => 'Jumlah stok harus berupa angka bulat.',
            'stock_quantity.min'        => 'Jumlah stok tidak boleh kurang dari 0.',
            'is_featured.boolean'       => 'Status unggulan harus berupa ya atau tidak.',
            'is_active.boolean'         => 'Status aktif harus berupa ya atau tidak.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'category_id'               => 'kategori',
            'name'                      => 'nama songket',
            'description'               => 'deskripsi',
            'base_price'                => 'harga',
            'colors'                    => 'warna',
            'images'                    => 'gambar',
            'stock_quantity'            => 'jumlah stok',
            'is_featured'               => 'status unggulan',
            'is_active'                 => 'status aktif',
        ];
    }
}
