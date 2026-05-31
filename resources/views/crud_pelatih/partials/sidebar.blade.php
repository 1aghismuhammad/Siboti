<aside class="trainer-sidebar">
    <div class="trainer-sidebar__logo">
        <svg width="28" height="28" viewBox="0 0 100 120" fill="none">
            <circle cx="50" cy="18" r="10" stroke="white" stroke-width="5" fill="none"/>
            <line x1="50" y1="28" x2="50" y2="65" stroke="white" stroke-width="5"/>
            <line x1="50" y1="45" x2="28" y2="35" stroke="white" stroke-width="4"/>
            <line x1="50" y1="45" x2="72" y2="35" stroke="white" stroke-width="4"/>
            <line x1="50" y1="65" x2="35" y2="90" stroke="white" stroke-width="4"/>
            <line x1="50" y1="65" x2="65" y2="90" stroke="white" stroke-width="4"/>
        </svg>
        <span class="trainer-sidebar__logo-text">SIBOT<span style="color:#CCFF00;">!</span></span>
    </div>
    <p class="trainer-sidebar__subtitle">Trainer Panel</p>

    <input type="text" class="trainer-sidebar__search"
           placeholder="Cari member..."
           onkeyup="filterMember(this.value)">

    <p class="trainer-sidebar__section-title">Member Saya</p>

    <div class="trainer-member-list" id="member-list">
        @foreach([
            ['RA','Rizky Adhitya','Paket Pro', true],
            ['NP','Nadia Pramesti','Paket Basic', false],
            ['DW','Danu Wicaksono','Paket Elite', false],
            ['SL','Sinta Lestari','Paket Pro', false],
        ] as $m)
        <a href="#" onclick="pilihMember('{{ $m[1] }}', event)"
           class="trainer-member-item {{ $m[3] ? 'trainer-member-item--active' : '' }}"
           data-name="{{ strtolower($m[1]) }}">
            <div class="trainer-member-item__avatar">{{ $m[0] }}</div>
            <div>
                <p class="trainer-member-item__name">{{ $m[1] }}</p>
                <p class="trainer-member-item__paket">{{ $m[2] }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div class="trainer-sidebar__footer">
        <div class="trainer-sidebar__footer-avatar">CD</div>
        <div>
            <p class="trainer-sidebar__footer-name">Coach Dimas</p>
            <p class="trainer-sidebar__footer-role">Personal Trainer</p>
        </div>
    </div>
</aside>

<script>
function filterMember(keyword) {
    const items = document.querySelectorAll('.trainer-member-item');
    items.forEach(item => {
        const name = item.dataset.name || '';
        item.style.display = name.includes(keyword.toLowerCase()) ? 'flex' : 'none';
    });
}

function pilihMember(nama, e) {
    e.preventDefault();
    const title = document.getElementById('member-title');
    if (title) title.textContent = nama + '.';
    document.querySelectorAll('.trainer-member-item').forEach(el => {
        el.classList.remove('trainer-member-item--active');
    });
    e.currentTarget.classList.add('trainer-member-item--active');
}
</script>