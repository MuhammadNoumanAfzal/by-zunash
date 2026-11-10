<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'permissions' => 'array',
    ];

    public static function availableModules(): array
    {
        return [
            'dashboard'     => ['name' => 'Dashboard Overview', 'icon' => 'layout-dashboard', 'desc' => 'Executive KPIs, sales charts & activity feed'],
            'categories'    => ['name' => 'Categories', 'icon' => 'layers', 'desc' => 'Collections & category curation'],
            'subcategories' => ['name' => 'Subcategories', 'icon' => 'git-branch', 'desc' => 'Granular silhouettes & classifications'],
            'products'      => ['name' => 'Atelier Products', 'icon' => 'shopping-bag', 'desc' => 'Product catalogue, pricing & imagery'],
            'deals'         => ['name' => 'Deals & Bundles', 'icon' => 'tag', 'desc' => 'Curated pairings, discounts & sets'],
            'inventory'     => ['name' => 'Inventory & Stock', 'icon' => 'boxes', 'desc' => 'Stock levels, restock alerts & logs'],
            'orders'        => ['name' => 'Store Orders', 'icon' => 'clipboard-list', 'desc' => 'Orders, fulfillment, invoices & dispatch'],
            'abandoned_carts' => ['name' => 'Abandoned Carts', 'icon' => 'shopping-cart', 'desc' => 'Drop-off tracking & 1-click WhatsApp recovery'],
            'coupons'       => ['name' => 'Coupons & Promos', 'icon' => 'ticket', 'desc' => 'Percentage & fixed vouchers, usage caps & rules'],
            'analytics'     => ['name' => 'Financial Analytics & Exports', 'icon' => 'line-chart', 'desc' => 'ROI margins, category profits, tax summary & CSV exports'],
            'customers'     => ['name' => 'Customers', 'icon' => 'users', 'desc' => 'Client records, addresses & purchase history'],
            'messages'      => ['name' => 'Inquiries & Messages', 'icon' => 'message-square', 'desc' => 'Patron inquiries, WhatsApp & support'],
            'reviews'       => ['name' => 'Reviews', 'icon' => 'star', 'desc' => 'Product reviews & testimonials'],
            'staff'         => ['name' => 'Staff & Roles (RBAC)', 'icon' => 'shield-check', 'desc' => 'Team access, role definitions & privileges'],
            'settings'      => ['name' => 'Atelier Settings', 'icon' => 'sliders', 'desc' => 'Hotline, taxes, shipping & store metadata'],
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function hasPermission(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $perms = $this->permissions;
        if (is_null($perms)) {
            if ($this->role === 'manager') {
                return in_array($module, ['dashboard', 'categories', 'subcategories', 'products', 'deals', 'inventory', 'orders', 'abandoned_carts', 'coupons', 'analytics', 'customers', 'messages', 'reviews']);
            }
            if ($this->role === 'editor') {
                return in_array($module, ['categories', 'subcategories', 'products', 'deals', 'reviews']);
            }
            return false;
        }

        return in_array($module, $perms);
    }

    public function hasAnyPermission(array $modules): bool
    {
        foreach ($modules as $module) {
            if ($this->hasPermission($module)) {
                return true;
            }
        }
        return false;
    }
}
