@auth
<a href="{{ route('orders.tracking.index') }}" style="color:var(--mid, #5A7FA0); line-height:1; transition:color 0.2s;" onmouseover="this.style.color='var(--rose, #5BB8F5)'" onmouseout="this.style.color='var(--mid, #5A7FA0)'" title="Lacak Pesanan">
    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
    </svg>
</a>
<a href="{{ route('notifications.index') }}" style="color:var(--mid, #5A7FA0); line-height:1; position:relative; transition:color 0.2s;" onmouseover="this.style.color='var(--rose, #5BB8F5)'" onmouseout="this.style.color='var(--mid, #5A7FA0)'" title="Notifikasi">
    <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
    </svg>
    @php $unreadCount = auth()->user()->myNotifications()->where('is_read', false)->count(); @endphp
    @if($unreadCount > 0)
    <span style="position:absolute; top:-6px; right:-6px; background:#5BB8F5; color:white; font-size:0.6rem; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600;">{{ $unreadCount }}</span>
    @endif
</a>
@endauth