# 🎨 DEISA Tailwind CSS Components Guide

## Overview

Kami telah membuat set komponen reusable dengan Tailwind CSS yang modern, responsif, dan dilengkapi dengan animasi smooth.

## Files

### Layouts
- **`resources/views/layouts/app-tailwind.blade.php`** - Layout utama dengan Tailwind CSS

### Components
- **`resources/views/components/button.blade.php`** - Button component
- **`resources/views/components/card.blade.php`** - Card component
- **`resources/views/components/alert.blade.php`** - Alert component
- **`resources/views/components/modal.blade.php`** - Modal component

### Views
- **`resources/views/dashboard-tailwind.blade.php`** - Dashboard example

---

## 🎯 Penggunaan

### 1. Button Component

```blade
<!-- Primary Button -->
<x-button variant="primary" size="md">
    Simpan
</x-button>

<!-- Secondary Button -->
<x-button variant="secondary" size="sm">
    Batal
</x-button>

<!-- Success Button -->
<x-button variant="success" size="lg">
    <svg class="w-4 h-4">...</svg>
    Setujui
</x-button>

<!-- Danger Button -->
<x-button variant="danger" size="md" type="button">
    Hapus
</x-button>

<!-- Warning Button -->
<x-button variant="warning" size="md">
    Peringatan
</x-button>

<!-- Info Button -->
<x-button variant="info" size="md">
    Informasi
</x-button>

<!-- Ghost Button -->
<x-button variant="ghost" size="md">
    Link Button
</x-button>

<!-- Button as Link -->
<x-button variant="primary" tag="a" href="{{ route('home') }}">
    Go Home
</x-button>

<!-- Disabled Button -->
<x-button variant="primary" disabled>
    Disabled
</x-button>
```

**Variants:** `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `ghost`

**Sizes:** `xs`, `sm`, `md`, `lg`, `xl`

---

### 2. Card Component

```blade
<!-- Default Card -->
<x-card title="Card Title">
    <p>Card content goes here</p>
</x-card>

<!-- Card with Subtitle and Icon -->
<x-card title="Statistics" subtitle="Last 30 days" variant="primary">
    <x-slot name="icon">
        <svg class="w-8 h-8 text-blue-600">...</svg>
    </x-slot>
    <p>Card content</p>
</x-card>

<!-- Card with Footer -->
<x-card title="Confirm Action" variant="warning">
    <p>Are you sure?</p>
    
    <x-slot name="footer">
        <button>Cancel</button>
        <button>Confirm</button>
    </x-slot>
</x-card>

<!-- Gradient Card -->
<x-card variant="gradient">
    <div class="text-center">
        <p class="text-4xl font-bold text-emerald-600">245</p>
        <p class="text-gray-600">Total Users</p>
    </div>
</x-card>
```

**Variants:** `default`, `primary`, `success`, `warning`, `danger`, `gradient`

---

### 3. Alert Component

```blade
<!-- Success Alert -->
<x-alert type="success" title="Berhasil">
    Data telah disimpan dengan sukses!
</x-alert>

<!-- Error Alert -->
<x-alert type="error" title="Terjadi Kesalahan">
    Gagal memproses data. Silakan coba lagi.
</x-alert>

<!-- Warning Alert -->
<x-alert type="warning" title="Peringatan">
    Aksi ini tidak dapat dibatalkan.
</x-alert>

<!-- Info Alert -->
<x-alert type="info" title="Informasi">
    Sistem sedang dalam pemeliharaan.
</x-alert>

<!-- Alert without Dismiss Button -->
<x-alert type="success" dismissible="false">
    This alert cannot be dismissed
</x-alert>
```

**Types:** `success`, `error`, `warning`, `info`

---

### 4. Modal Component

```blade
<!-- Basic Modal -->
<x-modal modalId="myModal" title="Modal Title">
    <p>Modal content goes here</p>
</x-modal>

<!-- Modal with Subtitle -->
<x-modal modalId="confirmModal" title="Confirm" subtitle="Please confirm your action">
    <p>Are you sure?</p>
</x-modal>

<!-- Modal with Custom Size -->
<x-modal modalId="largeModal" title="Large Modal" size="lg">
    <p>Large modal content</p>
</x-modal>

<!-- Modal with Custom Footer -->
<x-modal modalId="actionModal" title="Action">
    <p>Modal content</p>
    
    <x-slot name="footer">
        <button onclick="closeModal('actionModal')" class="px-4 py-2 bg-gray-200 rounded">
            Cancel
        </button>
        <button class="px-4 py-2 bg-emerald-500 text-white rounded">
            Confirm
        </button>
    </x-slot>
</x-modal>
```

**Sizes:** `sm`, `md`, `lg`, `xl`

**JavaScript Functions:**
```javascript
// Open modal
openModal('myModal');

// Close modal
closeModal('myModal');
```

---

## 📦 Complete Dashboard Example

See `resources/views/dashboard-tailwind.blade.php` for a full working example with:
- Statistics cards with gradients
- Responsive grid layout
- Patient list with status badges
- Activity timeline
- Quick action buttons
- Stok monitoring cards
- Chart containers

---

## 🎨 Color Palette

```
Primary:    Emerald (#10b981)
Secondary:  Cyan (#06b6d4)
Success:    Green (#22c55e)
Danger:     Red (#ef4444)
Warning:    Amber (#f59e0b)
Info:       Blue (#3b82f6)
```

---

## ✨ Built-in Animations

- `animate-fade-in` - Fade in animation
- `animate-slide-in-left` - Slide from left
- `animate-slide-in-right` - Slide from right
- `animate-slide-in-down` - Slide from top
- `animate-slide-in-up` - Slide from bottom
- `animate-scale-in` - Scale in animation
- `animate-pulse-glow` - Pulsing glow effect

**Usage:**
```blade
<div class="animate-fade-in">Fading in...</div>
<div class="animate-slide-in-down">Sliding down...</div>
```

---

## 🎯 Features

✅ Fully responsive design
✅ Smooth animations
✅ Gradient backgrounds
✅ Shadow effects
✅ Hover states
✅ Loading states
✅ Disabled states
✅ Custom variants
✅ Easy customization
✅ Dark mode ready (can be added)

---

## 🚀 Setup & Configuration

The layout is already configured to use:
- **Tailwind CSS v4** with `@tailwindcss/vite`
- **Vite** for build process
- **Laravel Blade** components

To use the Tailwind layout, extend it in your views:

```blade
@extends('layouts.app-tailwind')

@section('page_title', 'Your Page Title')
@section('page_subtitle', 'Subtitle')

@section('content')
    <!-- Your content here -->
@endsection
```

---

## 🎓 Best Practices

### 1. Component Props
Always pass required props:
```blade
<x-card title="Required Title" variant="primary">
    Content
</x-card>
```

### 2. Use Named Slots
```blade
<x-card title="Title">
    <x-slot name="icon">
        <svg>...</svg>
    </x-slot>
    
    Content
    
    <x-slot name="footer">
        Footer content
    </x-slot>
</x-card>
```

### 3. Proper Button Usage
```blade
<!-- For form submission -->
<x-button type="submit" variant="primary">Submit</x-button>

<!-- For navigation -->
<x-button tag="a" href="{{ route('home') }}" variant="primary">Home</x-button>

<!-- For actions -->
<x-button onclick="handleClick()" variant="secondary">Click Me</x-button>
```

### 4. Alerts Auto-dismiss
Alerts automatically disappear after 5 seconds. To disable:
```blade
<x-alert type="success" auto-dismiss="false">
    Message
</x-alert>
```

---

## 🔧 Customization

### Add Custom Variant
Edit `resources/views/components/button.blade.php`:

```php
'custom' => 'bg-purple-500 hover:bg-purple-600 text-white shadow-md hover:shadow-lg',
```

### Add Custom Animation
Edit `resources/views/layouts/app-tailwind.blade.php`:

```css
@keyframes customAnimation {
    /* your animation */
}

.animate-custom {
    animation: customAnimation 0.4s ease-out;
}
```

---

## 🐛 Troubleshooting

### Tailwind Styles Not Working
1. Ensure Vite is running: `npm run dev`
2. Clear cache: `php artisan view:clear`
3. Build assets: `npm run build`

### Components Not Found
1. Check component file exists in `resources/views/components/`
2. Component name should match filename (kebab-case)
3. Clear component cache

### Animations Not Showing
1. Check animations are defined in layout CSS
2. Ensure classes are spelled correctly
3. Check if `overflow: hidden` is not cutting off animations

---

## 📚 Resources

- [Tailwind CSS Documentation](https://tailwindcss.com)
- [Tailwind CSS v4 Changes](https://tailwindcss.com/blog/tailwindcss-v4)
- [Laravel Blade Components](https://laravel.com/docs/blade#components)

---

## 🎉 Next Steps

1. Replace your current dashboard route to use `dashboard-tailwind`
2. Create more pages using the layout
3. Customize colors to match your brand
4. Add more animations as needed

---

**Last Updated:** January 11, 2026
**Version:** 1.0
**Status:** Production Ready
