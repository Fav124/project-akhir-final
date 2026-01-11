# 🎨 Quick Reference - Tailwind Components

## Components Locations
```
resources/views/components/
├── button.blade.php
├── card.blade.php
├── alert.blade.php
└── modal.blade.php
```

## Component Usage Examples

### 1️⃣ Button Component
```blade
<!-- Basic -->
<x-button label="Click Me" />

<!-- With variant and size -->
<x-button variant="primary" size="lg" label="Large Button" />

<!-- As link -->
<x-button variant="secondary" href="{{ route('home') }}" label="Go Home" />

<!-- As form submit -->
<x-button type="submit" variant="success">Save</x-button>

<!-- Disabled state -->
<x-button disabled label="Disabled" />

<!-- With icon slot -->
<x-button variant="danger">
    <svg>...</svg> Delete
</x-button>

<!-- Variants: primary, secondary, success, danger, warning, info, ghost -->
<!-- Sizes: xs, sm, md (default), lg, xl -->
```

### 2️⃣ Card Component
```blade
<!-- Simple card -->
<x-card>
    Content here
</x-card>

<!-- With title -->
<x-card title="Card Title">
    Content here
</x-card>

<!-- With title and subtitle -->
<x-card title="Title" subtitle="Subtitle">
    Content here
</x-card>

<!-- Different variants -->
<x-card variant="primary" title="Primary">...</x-card>
<x-card variant="success" title="Success">...</x-card>
<x-card variant="gradient" title="Gradient">...</x-card>

<!-- Variants: default, primary, success, warning, danger, gradient -->

<!-- With footer slot -->
<x-card title="Actions">
    Content
    <x-slot name="footer">
        <button>Action</button>
    </x-slot>
</x-card>
```

### 3️⃣ Alert Component
```blade
<!-- Success -->
<x-alert type="success" title="Berhasil!" message="Data saved successfully" />

<!-- Error -->
<x-alert type="error" title="Error!" message="Something went wrong" />

<!-- Warning -->
<x-alert type="warning" title="Perhatian!" message="Please check your input" />

<!-- Info -->
<x-alert type="info" title="Info" message="This is informational" />

<!-- With HTML content -->
<x-alert type="success" title="Success">
    <p>Complex content here</p>
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
    </ul>
</x-alert>

<!-- Auto dismiss (5 seconds) -->
<!-- Already built-in, no config needed -->
```

### 4️⃣ Modal Component
```blade
<!-- Simple modal -->
<x-modal id="myModal" title="Modal Title">
    Content here
</x-modal>

<!-- With action footer -->
<x-modal id="deleteModal" title="Confirm Delete" variant="danger">
    Are you sure?
    <x-slot name="footer">
        <button onclick="closeModal('deleteModal')">Cancel</button>
        <button class="bg-red-500">Delete</button>
    </x-slot>
</x-modal>

<!-- Sizes: sm, md (default), lg, xl -->
<x-modal id="large" title="Large Modal" size="lg">
    Large content
</x-modal>

<!-- JavaScript functions -->
<!-- openModal('id') - Open modal -->
<!-- closeModal('id') - Close modal -->
```

---

## Tailwind Classes Cheat Sheet

### Spacing (4px = 1 unit)
```
p-4    = padding 16px
px-4   = padding-left/right 16px
py-4   = padding-top/bottom 16px
m-4    = margin 16px
mx-auto = margin-left/right auto (center)
gap-4  = gap 16px (flex/grid)
```

### Colors
```
text-gray-900     = text color
text-gray-600     = muted text
bg-emerald-500    = background color
border-gray-300   = border color
hover:bg-gray-100 = hover state
```

### Layout
```
flex              = display: flex
flex-col          = flex-direction: column
flex-row          = flex-direction: row
md:flex-row       = row only on tablet+
grid              = display: grid
md:grid-cols-2    = 2 columns on tablet+
justify-between   = space-between
items-center      = align-items: center
gap-4             = gap 16px
```

### Sizing
```
w-full   = width 100%
h-10     = height 40px
min-h-96 = min-height 384px
```

### Display
```
block        = display: block
inline-flex  = display: inline-flex
hidden       = display: none
md:hidden    = hidden on tablet+
```

### Rounded & Borders
```
rounded    = border-radius 4px
rounded-lg = border-radius 8px
border     = border 1px
border-2   = border 2px
```

### Shadows
```
shadow-sm = small shadow
shadow-md = medium shadow
shadow-lg = large shadow
hover:shadow-lg = shadow on hover
```

### Transitions
```
transition-all      = all properties
transition-colors   = color properties only
duration-300        = 300ms timing
hover:opacity-80    = hover effect
```

---

## Form Inputs Styling Pattern

```blade
<label for="input" class="block text-sm font-medium text-gray-700 mb-2">
    Label <span class="text-red-500">*</span>
</label>
<input 
    type="text" 
    id="input" 
    name="input"
    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
    required>
@error('input')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
```

---

## Common Patterns

### Header with Title
```blade
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Page Title</h1>
    <p class="text-gray-600 mt-2">Subtitle or description</p>
</div>
```

### Action Buttons
```blade
<div class="flex gap-3 justify-end">
    <a href="#" class="px-6 py-2.5 rounded-lg font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
        Cancel
    </a>
    <button class="px-6 py-2.5 rounded-lg font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
        Save
    </button>
</div>
```

### Table Row
```blade
<tr class="hover:bg-gray-50 transition-colors">
    <td class="px-6 py-4 text-sm font-medium text-gray-900">Data</td>
    <td class="px-6 py-4 text-sm text-gray-700">Value</td>
    <td class="px-6 py-4">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
            Active
        </span>
    </td>
</tr>
```

### Badge
```blade
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
    Status
</span>
```

### Empty State
```blade
<div class="text-center py-12">
    <svg class="mx-auto h-12 w-12 text-gray-400">...</svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">No data</h3>
    <p class="mt-1 text-gray-600">Description here</p>
</div>
```

---

## Responsive Breakpoints

```
Default  = Mobile (0px)
sm       = 640px
md       = 768px (Tablet)
lg       = 1024px (Desktop)
xl       = 1280px (Wide)
2xl      = 1536px (Extra Wide)
```

Usage: `md:grid-cols-2` = 2 columns on tablet and up

---

## Tips & Tricks

1. **Hover States**: `hover:bg-emerald-600 hover:shadow-lg`
2. **Focus States**: `focus:outline-none focus:border-emerald-500 focus:ring-2`
3. **Transitions**: Always add `transition-all` or `transition-colors`
4. **Gradients**: `bg-gradient-to-r from-emerald-500 to-emerald-600`
5. **Opacity**: Use `opacity-50` for 50% opacity
6. **Shadows**: Use `shadow-md` for 3D depth
7. **Group Hover**: `.group:hover .group-hover:block` for group effects
8. **Accessibility**: Always use proper labels and semantic HTML

---

Generated at: {{ date('Y-m-d H:i:s') }}
Keep this file handy when building new views! 📚
