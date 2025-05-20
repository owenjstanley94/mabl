<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-3" />
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item href="/" :current="request()->is('/')" wire:navigate>Home</flux:navbar.item>
        <flux:navbar.item href="/fixtures" :current="request()->is('fixtures')" wire:navigate>Fixtures</flux:navbar.item>
        <flux:navbar.item href="/teams" :current="request()->is('teams')" wire:navigate>Teams</flux:navbar.item>
        <flux:navbar.item href="/officials" :current="request()->is('officials')" wire:navigate>Officials</flux:navbar.item>
        <flux:navbar.item href="/organisation" :current="request()->is('organisation')" wire:navigate>Organisation</flux:navbar.item>
        <flux:navbar.item href="/notices" :current="request()->is('notices')" wire:navigate>Notices</flux:navbar.item>
    </flux:navbar>
</flux:header>
<flux:sidebar stashable sticky
    class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
    <flux:navlist variant="outline">
        <flux:navlist.item href="/" :current="request()->is('/')" wire:navigate>Home</flux:navlist.item>
        <flux:navlist.item href="/fixtures" :current="request()->is('fixtures')" wire:navigate>Fixtures</flux:navlist.item>
        <flux:navlist.item href="/teams" :current="request()->is('teams')" wire:navigate>Teams</flux:navlist.item>
        <flux:navlist.item href="/officials" :current="request()->is('officials')" wire:navigate>Officials</flux:navlist.item>
        <flux:navlist.item href="/organisation" :current="request()->is('organisation')" wire:navigate>Organisation</flux:navlist.item>
        <flux:navlist.item href="/notices" :current="request()->is('notices')" wire:navigate>Notices</flux:navlist.item>
    </flux:navlist>
</flux:sidebar> 