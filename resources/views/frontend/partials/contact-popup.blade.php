@php
    $cpWaRaw   = preg_replace('/[^0-9]/', '', (string) ($site->whatsapp_number ?? ''));
    // 01XXXXXXXXX hole Bangladesh country code (880) jure dao
    if (strlen($cpWaRaw) === 11 && str_starts_with($cpWaRaw, '0')) {
        $cpWaRaw = '88' . $cpWaRaw;
    }
    $cpWa = $cpWaRaw !== '' ? 'https://wa.me/' . $cpWaRaw : null;

    $cpMessenger = !empty($site->messenger_link) ? $site->messenger_link : null;

    // messenger_link na thakle Facebook page URL theke m.me link banao
    if (!$cpMessenger && !empty($site->facebook_url)) {
        $fbPath = trim((string) parse_url($site->facebook_url, PHP_URL_PATH), '/');
        $fbUser = explode('/', $fbPath)[0] ?? '';
        if ($fbUser !== '' && !in_array($fbUser, ['profile.php', 'pages', 'people', 'groups'])) {
            $cpMessenger = 'https://m.me/' . $fbUser;
        }
    }

    $cpEmailList = array_values(array_filter([$site->email_1 ?? null, $site->email_2 ?? null, $site->email_3 ?? null]));
    $cpEmail     = count($cpEmailList) ? $cpEmailList[0] : null;

    // WhatsApp icon dekhar shomoy click korle ei link e jabe
    $cpWaDirect = $cpWa ? $cpWa . '?text=' . rawurlencode('Hello, I need help.') : '';
@endphp

@if($cpWa || $cpMessenger || $cpEmail)
<style>
    /* ===== Floating contact popup (cp) — only #fd6801, #2a3582, #ffffff ===== */
    .cp-wrap{position:fixed;left:20px;bottom:24px;z-index:9990;font-family:'Poppins','Open Sans',sans-serif}
    .cp-wrap *{box-sizing:border-box}

    /* floating button */
    .cp-fab{position:relative;display:inline-flex;align-items:center;gap:0;height:58px;padding:0 8px;border:0;border-radius:50px;background:#fd6801;color:#ffffff;font-size:15px;font-weight:700;cursor:pointer;box-shadow:0 10px 26px rgba(253,104,1,.45);transition:transform .2s ease,box-shadow .2s ease}
    .cp-fab:hover{transform:translateY(-3px);box-shadow:0 14px 32px rgba(253,104,1,.55)}

    /* icon circle: headset <-> WhatsApp fade toggle (5 second por por) */
    .cp-fab-ico{position:relative;width:42px;height:42px;border-radius:50%;background:#ffffff;color:#2a3582;display:inline-flex;align-items:center;justify-content:center;flex:0 0 42px}
    .cp-fab-ico svg{position:absolute;top:50%;left:50%;width:24px;height:24px;margin:-12px 0 0 -12px;transition:opacity .35s ease,transform .35s ease}
    .cp-fab-contact-icon{opacity:1;transform:scale(1)}
    .cp-fab-whatsapp-icon{opacity:0;transform:scale(.5);color:#25D366}
    .cp-wrap.cp-wa-state .cp-fab-contact-icon{opacity:0;transform:scale(.5)}
    .cp-wrap.cp-wa-state .cp-fab-whatsapp-icon{opacity:1;transform:scale(1)}

    /* Keep the label in sync with the alternating icon. */
    .cp-fab-text{white-space:nowrap;overflow:hidden;max-width:140px;padding:0 14px 0 10px;opacity:1;transition:max-width .4s ease,opacity .3s ease,padding .4s ease}
    .cp-fab-whatsapp-label{display:none}
    .cp-wrap.cp-wa-state .cp-fab-contact-label{display:none}
    .cp-wrap.cp-wa-state .cp-fab-whatsapp-label{display:inline}

    .cp-fab:before{content:"";position:absolute;inset:0;border-radius:50px;box-shadow:0 0 0 0 rgba(253,104,1,.55);animation:cpPulse 2.2s infinite;pointer-events:none}
    @keyframes cpPulse{70%{box-shadow:0 0 0 16px rgba(253,104,1,0)}100%{box-shadow:0 0 0 0 rgba(253,104,1,0)}}
    .cp-wrap.open .cp-fab:before{animation:none}

    /* popup card */
    .cp-pop{position:absolute;left:0;bottom:74px;width:330px;max-width:calc(100vw - 32px);background:#ffffff;border-radius:22px;overflow:hidden;box-shadow:0 24px 60px rgba(42,53,130,.30);border:1px solid rgba(42,53,130,.12);opacity:0;visibility:hidden;transform:translateY(16px) scale(.97);transform-origin:bottom left;transition:all .25s ease}
    .cp-wrap.open .cp-pop{opacity:1;visibility:visible;transform:none}

    .cp-head{position:relative;background:#2a3582;color:#ffffff;padding:20px 20px 18px;border-bottom:4px solid #fd6801}
    .cp-head h4{margin:0 0 4px;font-size:18px;font-weight:700;color:#ffffff!important}
    .cp-head p{margin:0;font-size:13px;color:#ffffff;opacity:.85;display:flex;align-items:center;gap:8px}
    .cp-head p:before{content:"";width:8px;height:8px;border-radius:50%;background:#fd6801;box-shadow:0 0 0 3px rgba(253,104,1,.3)}
    .cp-close{position:absolute;top:14px;right:14px;width:32px;height:32px;border:0;border-radius:50%;background:rgba(255,255,255,.18);color:#ffffff;display:inline-flex;align-items:center;justify-content:center;padding:0;cursor:pointer;transition:background .2s}
    .cp-close:hover{background:#fd6801}
    .cp-close svg{width:14px;height:14px}

    .cp-list{padding:12px}
    .cp-item{display:flex;align-items:center;gap:14px;padding:12px;border-radius:14px;text-decoration:none!important;color:#2a3582;border:1px solid transparent;transition:all .2s ease}
    .cp-item+.cp-item{margin-top:6px}
    .cp-item:hover{background:rgba(253,104,1,.06);border-color:rgba(253,104,1,.35);transform:translateX(4px);color:#2a3582}
    .cp-ico{flex:0 0 48px;width:48px;height:48px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:#ffffff}
    .cp-ico svg{width:24px;height:24px}
    .cp-ico.o{background:#fd6801;box-shadow:0 6px 16px rgba(253,104,1,.35)}
    .cp-ico.n{background:#2a3582;box-shadow:0 6px 16px rgba(42,53,130,.35)}
    .cp-txt{flex:1;min-width:0}
    .cp-txt b{display:block;font-size:15px;font-weight:700;color:#2a3582;line-height:1.3}
    .cp-txt span{display:block;font-size:12.5px;color:#2a3582;opacity:.7;line-height:1.4;word-break:break-word}
    .cp-go{flex:0 0 auto;width:28px;height:28px;border-radius:50%;background:rgba(42,53,130,.08);color:#2a3582;display:inline-flex;align-items:center;justify-content:center;transition:all .2s}
    .cp-go svg{width:14px;height:14px}
    .cp-item:hover .cp-go{background:#fd6801;color:#ffffff}

    .cp-foot{padding:10px 16px 14px;text-align:center;font-size:12px;color:#2a3582;opacity:.65}

    /* mobile : bottom nav (62px) er upore.
       Label "Contact Us" 2 second por por ashe-jay (JS .cp-show class toggle kore) */
    @media(max-width:1199px){
        .cp-wrap{left:14px;bottom:78px}
        .cp-fab{height:52px;padding:0 5px;gap:0}
        .cp-fab-ico{width:42px;height:42px;background:#ffffff;color:#2a3582;flex:0 0 42px}
        .cp-fab-text{max-width:0;overflow:hidden;opacity:0;padding:0;transition:max-width .45s ease,opacity .35s ease,padding .45s ease}
        .cp-wrap.cp-show:not(.open) .cp-fab-text{max-width:120px;opacity:1;padding:0 14px 0 10px}
        .cp-wrap.cp-wa-state .cp-fab-text{max-width:120px!important;opacity:1!important;padding:0 14px 0 10px!important}
        .cp-pop{bottom:66px}
    }
</style>

<div class="cp-wrap" id="cpWrap">

    <div class="cp-pop" id="cpPop" role="dialog" aria-label="Contact us">
        <div class="cp-head">
            <h4>Contact Us</h4>
            <p>We are online 24/7 to help you</p>
            <button type="button" class="cp-close" id="cpClose" aria-label="Close">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 3l10 10M13 3L3 13"/></svg>
            </button>
        </div>

        <div class="cp-list">
            @if($cpWa)
                <a class="cp-item" href="{{ $cpWaDirect }}" target="_blank" rel="noopener">
                    <span class="cp-ico o">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5.1-1.3A10 10 0 1 0 12 2zm0 18.2c-1.5 0-2.9-.4-4.1-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1-.2.2-.7.8-.8 1-.2.2-.3.2-.5.1-.8-.4-1.6-.9-2.3-1.6-.6-.6-1-1.2-1.4-1.9-.1-.2 0-.4.1-.5l.4-.4c.1-.1.2-.3.2-.4.1-.1 0-.3 0-.4-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.6.3-.2.2-.8.8-.8 1.9s.8 2.2.9 2.3c.1.2 1.6 2.4 3.8 3.4 1.4.6 1.9.6 2.6.5.4-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2-.1-.2-.2-.2-.5-.4z"/></svg>
                    </span>
                    <span class="cp-txt"><b>WhatsApp</b><span>Chat with us directly</span></span>
                    <span class="cp-go"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></span>
                </a>
            @endif

            @if($cpMessenger)
                <a class="cp-item" href="{{ $cpMessenger }}" target="_blank" rel="noopener">
                    <span class="cp-ico n">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.2 2 11.4c0 2.9 1.4 5.5 3.6 7.2V22l3.3-1.8c1 .3 2 .4 3.1.4 5.5 0 10-4.2 10-9.4S17.5 2 12 2zm1 12.6-2.5-2.7-4.9 2.7 5.4-5.7 2.6 2.7 4.8-2.7-5.4 5.7z"/></svg>
                    </span>
                    <span class="cp-txt"><b>Messenger</b><span>Message us on Facebook</span></span>
                    <span class="cp-go"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></span>
                </a>
            @endif

            @if($cpEmail)
                <a class="cp-item" href="mailto:{{ $cpEmail }}?subject={{ rawurlencode('Support request') }}">
                    <span class="cp-ico o">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.2-8 5-8-5V6l8 5 8-5v2.2z"/></svg>
                    </span>
                    <span class="cp-txt"><b>Email</b><span>{{ $cpEmail }}</span></span>
                    <span class="cp-go"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg></span>
                </a>
            @endif
        </div>

        <div class="cp-foot">Usually replies within minutes</div>
    </div>

    <button type="button" class="cp-fab" id="cpFab" aria-label="Contact us" aria-expanded="false" data-wa="{{ $cpWaDirect }}">
        <span class="cp-fab-ico">
            <svg class="cp-fab-contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="2.5" y="13" width="4.5" height="7" rx="2"/><rect x="17" y="13" width="4.5" height="7" rx="2"/><path d="M19.5 20c0 1.5-1.5 2-4 2h-2"/></svg>
            <svg class="cp-fab-whatsapp-icon" viewBox="0 0 448 512" fill="currentColor" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32 101.5 32 1.9 131.6 1.9 254c0 39.1 10.2 77.3 29.5 111L0 480l118.2-31c32.6 17.8 69.3 27.2 105.6 27.2h.1c122.3 0 222-99.6 222-222 0-59.3-23.1-115.1-65-157.1zM223.9 438.7c-32.9 0-65.2-8.8-93.3-25.5l-6.7-4-70.1 18.4 18.7-68.4-4.4-7c-18.6-29.6-28.4-63.7-28.4-98.2 0-101.4 82.5-183.9 184-183.9 49.1 0 95.2 19.1 129.9 53.9s53.8 80.9 53.8 130c-.1 101.4-82.6 183.7-183.5 183.7zm101-137.8c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.5-14.3 18-17.6 21.7-3.2 3.7-6.5 4.2-12 1.4-32.8-16.4-54.3-29.3-76-66.4-5.7-9.8 5.7-9.1 16.4-30.2 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2s-9.7 1.4-14.8 6.9c-5.1 5.5-19.4 19-19.4 46.3s19.9 53.7 22.6 57.4c2.8 3.7 39.1 59.7 94.7 83.7 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.7z"/></svg>
        </span>
        <span class="cp-fab-text"><span class="cp-fab-contact-label">Contact Us</span><span class="cp-fab-whatsapp-label">WhatsApp</span></span>
    </button>
</div>

<script>
    (function () {
        var wrap = document.getElementById('cpWrap');
        var fab  = document.getElementById('cpFab');
        var xBtn = document.getElementById('cpClose');
        if (!wrap || !fab) return;

        var waUrl = fab.getAttribute('data-wa') || '';

        function setOpen(on) {
            wrap.classList.toggle('open', on);
            fab.setAttribute('aria-expanded', on ? 'true' : 'false');
        }

        // WhatsApp icon dekhale shorashori WhatsApp, headset dekhale popup
        fab.addEventListener('click', function () {
            if (waUrl && wrap.classList.contains('cp-wa-state')) {
                setOpen(false);
                window.open(waUrl, '_blank', 'noopener');
                return;
            }
            setOpen(!wrap.classList.contains('open'));
        });
        if (xBtn) xBtn.addEventListener('click', function () { setOpen(false); });

        // bairey click korle bondho
        document.addEventListener('click', function (e) {
            if (wrap.classList.contains('open') && !wrap.contains(e.target)) setOpen(false);
        });
        // Esc chaple bondho
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });

        // 5 second por por: headset + "Contact Us"  <->  WhatsApp icon + label
        // WhatsApp number na thakle toggle hobe na, popup khola thakle toggle pause thakbe
        if (waUrl) {
            window.setInterval(function () {
                if (wrap.classList.contains('open')) return;
                wrap.classList.toggle('cp-wa-state');
                fab.setAttribute('aria-label', wrap.classList.contains('cp-wa-state') ? 'Chat on WhatsApp' : 'Contact us');
            }, 5000);
        }

        // Mobile label show/hide cycle for the Contact Us state.
        var mq = window.matchMedia('(max-width:1199px)');
        var shown = false;
        setInterval(function () {
            if (!mq.matches) { wrap.classList.remove('cp-show'); return; }
            shown = !shown;
            wrap.classList.toggle('cp-show', shown);
        }, 2000);
    })();
</script>
@endif
