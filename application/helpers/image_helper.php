<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('article_image')) {
    /**
     * Get article image URL with fallback
     * 
     * @param object $article Article object
     * @return string|null Image URL or null
     */
    function article_image($article) {
        if (empty($article)) {
            return null;
        }
        
        $gambar = null;
        if (!empty($article->thumbnail)) {
            $gambar = trim($article->thumbnail);
        } elseif (!empty($article->gambar_header)) {
            $gambar = trim($article->gambar_header);
        }
        
        if ($gambar) {
            // Jika path sudah lengkap, ambil hanya nama file
            if (strpos($gambar, 'assets/img/articles/') !== false) {
                $gambar = basename($gambar);
            }
            return base_url('assets/img/articles/' . $gambar);
        }
        
        return null;
    }
}

if (!function_exists('pupuk_image')) {
    /**
     * Get pupuk image URL
     * 
     * @param object $pupuk Pupuk object
     * @return string|null Image URL or null
     */
    function pupuk_image($pupuk) {
        if (empty($pupuk) || empty($pupuk->gambar_pupuk)) {
            return null;
        }
        
        $gambar = trim($pupuk->gambar_pupuk);
        // Jika path sudah lengkap, ambil hanya nama file
        if (strpos($gambar, 'assets/img/pupuk/') !== false) {
            $gambar = basename($gambar);
        }
        
        return base_url('assets/img/pupuk/' . $gambar);
    }
}

if (!function_exists('penyakit_image')) {
    /**
     * Get penyakit image URL
     * 
     * @param object $penyakit Penyakit object
     * @return string|null Image URL or null
     */
    function penyakit_image($penyakit) {
        if (empty($penyakit) || empty($penyakit->gambar_ilustrasi)) {
            return null;
        }
        
        $gambar = trim($penyakit->gambar_ilustrasi);
        // Jika path sudah lengkap, ambil hanya nama file
        if (strpos($gambar, 'assets/img/penyakit/') !== false) {
            $gambar = basename($gambar);
        }
        
        return base_url('assets/img/penyakit/' . $gambar);
    }
}

if (!function_exists('user_image')) {
    /**
     * Get user profile image URL
     * 
     * @param object|string $user User object or foto_profil string
     * @return string|null Image URL or null
     */
    function user_image($user) {
        $foto = null;
        if (is_object($user)) {
            $foto = !empty($user->foto_profil) ? trim($user->foto_profil) : null;
        } elseif (is_string($user)) {
            $foto = trim($user);
        }
        
        if ($foto) {
            // Jika path sudah lengkap, ambil hanya nama file
            if (strpos($foto, 'assets/img/users/') !== false) {
                $foto = basename($foto);
            }
            return base_url('assets/img/users/' . $foto);
        }
        
        return null;
    }
}

