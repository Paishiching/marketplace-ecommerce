<style>
    /* ===== Card SKU + specification dropdown — only #fd6801, #2a3582, #ffffff ===== */

    .eb-sku-link{position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;gap:6px;width:100%;min-height:24px;flex:0 0 auto;box-sizing:border-box;margin:8px 0 0;padding:4px 0 2px;border:0;background:transparent;font-family:inherit;font-size:12.5px;font-weight:600;line-height:1.3;color:#2a3582;text-align:left;cursor:pointer;-webkit-appearance:none;appearance:none}
    .eb-sku-link .eb-sku-txt{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .eb-sku-link b{color:#fd6801;font-weight:700}
    .eb-sku-link:hover{color:#fd6801}
    .eb-sku-link:after{content:"";flex:0 0 auto;width:6px;height:6px;border-right:2px solid #fd6801;border-bottom:2px solid #fd6801;transform:rotate(45deg) translateY(-2px);transition:transform .2s}
    .eb-pc.spec-open .eb-sku-link:after{transform:rotate(-135deg) translateY(1px)}

    .eb-spec-drop{display:none;position:absolute;left:0;right:0;top:100%;z-index:70;background:#ffffff;border-top:1px solid rgba(42,53,130,.14);border-radius:0 0 12px 12px;box-shadow:0 16px 28px rgba(42,53,130,.18);padding:6px 14px 10px;text-align:left}
    .eb-spec-floating{position:fixed!important;left:0;top:0;right:auto;bottom:auto;z-index:2147483000!important;display:none;max-width:calc(100vw - 16px);max-height:calc(100vh - 16px);overflow-y:auto;background:#fff}
    .eb-spec-floating.is-visible{display:block!important}
    .eb-spec-wrap{position:relative;display:block}

    /* list : proti spec ek line (theme CSS override korte !important) */
    .eb-spec-list{display:block!important;margin:0!important;padding:0!important;list-style:none!important;max-height:104px;overflow:hidden}
    .eb-spec-row{display:block!important;float:none!important;width:100%!important;margin:0!important;padding:6px 0!important;font-size:13px;line-height:1.5;color:#2a3582;word-break:break-word;text-align:left;box-sizing:border-box}
    .eb-spec-row b{display:inline;font-weight:600;color:#2a3582}
    .eb-spec-row span{display:inline;color:rgba(42,53,130,.6)}
    .eb-spec-empty{padding:8px 0 2px;font-size:13px;color:rgba(42,53,130,.7)}

    .eb-spec-more{position:absolute;left:0;right:0;bottom:0;height:44px;display:flex;align-items:flex-end;justify-content:center;padding:0 0 2px;border:0;background:linear-gradient(to bottom,rgba(255,255,255,0),#ffffff 75%);color:#fd6801;font-size:22px;font-weight:700;line-height:1;letter-spacing:3px;cursor:pointer;-webkit-appearance:none;appearance:none}
    .eb-spec-more:hover{color:#2a3582}

    .eb-spec-drop.expanded .eb-spec-list{max-height:300px;overflow-y:auto;padding-right:6px!important;scrollbar-width:thin;scrollbar-color:rgba(42,53,130,.35) #ffffff}
    .eb-spec-drop.expanded .eb-spec-list::-webkit-scrollbar{width:6px}
    .eb-spec-drop.expanded .eb-spec-list::-webkit-scrollbar-thumb{background:rgba(42,53,130,.35);border-radius:6px}
    .eb-spec-drop.expanded .eb-spec-list::-webkit-scrollbar-track{background:#ffffff}
    .eb-spec-drop.expanded .eb-spec-more{display:none}

    .eb-pc.spec-open{z-index:60;transform:none!important}
    .eb-pc.spec-open .eb-spec-drop{display:block}
    .eb-pc.has-spec.spec-open{border-bottom-left-radius:0;border-bottom-right-radius:0}

    /* Desktop : mouse hover korlei dekhabe */
    @media (hover:hover) and (min-width:992px){
        .eb-pc.has-spec:hover{z-index:60;transform:none;border-bottom-left-radius:0;border-bottom-right-radius:0}
        .eb-pc.has-spec:hover .eb-spec-drop{display:block}

        /* Keep the in-card source hidden and float the popup above cards,
           images, and banners without changing the product row height. */
        .eb-pc .eb-spec-drop{display:none!important}
    }

    /* Mobile / Tablet : card-er bhitore khulbe */
    @media (max-width:991px){
        .eb-prod-row{align-items:flex-start}
        .eb-pc .eb-spec-drop{display:none!important}
        .eb-pc.has-spec.spec-open{border-bottom-left-radius:12px;border-bottom-right-radius:12px}
        .eb-spec-row{font-size:12.5px}
        .eb-sku-link{font-size:12px}
    }
</style>

<script>
    (function () {
        var url     = "{{ route('product.specs') }}";
        var cache   = {};
        var desktop = window.matchMedia('(hover:hover) and (min-width:992px)');

        function esc(s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        // name-er sheshe ":" thakle remove (double colon fix)
        function cleanName(s) {
            return String(s == null ? '' : s).replace(/[\s:：]+$/, '').trim();
        }

        function build(card, info) {
            if (card.querySelector('.eb-spec-drop')) return;

            var specs = (info && info.specs) ? info.specs : [];
            var drop  = document.createElement('div');
            drop.className = 'eb-spec-drop';

            if (!specs.length) {
                drop.classList.add('expanded');
                drop.innerHTML = '<div class="eb-spec-empty">No specification added yet.</div>';
            } else {
                // proti spec ekta alada div row => "Brand: Sony" / "memory: 250"
                var rows = specs.map(function (r) {
                    var val = (r.value == null || String(r.value).trim() === '') ? '-' : r.value;
                    return '<div class="eb-spec-row"><b>' + esc(cleanName(r.name)) + ':</b> <span>' + esc(val) + '</span></div>';
                }).join('');

                var more = specs.length > 3
                    ? '<button type="button" class="eb-spec-more" aria-label="Show all specifications">&bull;&bull;&bull;</button>'
                    : '';

                drop.innerHTML = '<div class="eb-spec-wrap"><div class="eb-spec-list">' + rows + '</div>' + more + '</div>';
                if (!more) drop.classList.add('expanded');
            }

            card.appendChild(drop);
            card.classList.add('has-spec');

            var floating = drop.cloneNode(true);
            floating.classList.add('eb-spec-floating');
            floating._specCard = card;
            document.body.appendChild(floating);
            card._floatingSpec = floating;
            if (desktop.matches && card.matches(':hover')) show(card);
        }

        function positionFloating(card) {
            var drop = card._floatingSpec;
            var button = card.querySelector('.eb-sku-link');
            if (!drop || !button) return;

            var rect = button.getBoundingClientRect();
            var width = Math.min(rect.width, window.innerWidth - 16);
            var left = Math.max(8, Math.min(rect.left, window.innerWidth - width - 8));

            drop.style.width = width + 'px';
            drop.style.left = left + 'px';
            drop.style.top = '8px';
            drop.classList.add('is-visible');
            drop.style.visibility = 'hidden';

            var height = Math.min(drop.scrollHeight, window.innerHeight - 16);
            var top = rect.bottom + 4;
            if (top + height > window.innerHeight - 8) {
                top = rect.top - height - 4;
            }
            top = Math.max(8, Math.min(top, window.innerHeight - height - 8));

            drop.style.top = top + 'px';
            drop.style.visibility = '';
        }

        function show(card) {
            card.classList.add('spec-open');
            var marquee = card.closest('.eb-prod-marquee');
            if (marquee) {
                marquee.classList.add('spec-hovering');
                var track = marquee.querySelector('.eb-prod-track');
                if (track) track.style.animationPlayState = 'paused';
            }
            var button = card.querySelector('.eb-sku-link');
            if (button) button.setAttribute('aria-expanded', 'true');
            if (card._floatingSpec) positionFloating(card);
        }

        function reset(card) {
            card.classList.remove('spec-open');
            var marquee = card.closest('.eb-prod-marquee');
            if (marquee && !marquee.querySelector('.eb-pc.spec-open')) {
                marquee.classList.remove('spec-hovering');
                var track = marquee.querySelector('.eb-prod-track');
                if (track) track.style.animationPlayState = '';
            }
            var d = card.querySelector('.eb-spec-drop');
            if (d && d.querySelector('.eb-spec-more')) d.classList.remove('expanded');
            if (card._floatingSpec) {
                card._floatingSpec.classList.remove('is-visible', 'expanded');
                card._floatingSpec.style.visibility = '';
            }
            var b = card.querySelector('.eb-sku-link');
            if (b) b.setAttribute('aria-expanded', 'false');
        }

        function closeAll(except) {
            document.querySelectorAll('.eb-pc.spec-open, .eb-pc .eb-spec-drop.expanded').forEach(function (el) {
                var card = el.classList && el.classList.contains('eb-pc') ? el : el.closest('.eb-pc');
                if (card && card !== except) reset(card);
            });
        }

        function scan() {
            var cards = Array.prototype.slice.call(document.querySelectorAll('.eb-pc[data-pid]:not([data-spec-ready])'));
            if (!cards.length) return;

            var ids = [];
            cards.forEach(function (c) {
                c.setAttribute('data-spec-ready', '1');
                var id = c.getAttribute('data-pid');
                if (id && ids.indexOf(id) === -1) ids.push(id);
            });

            for (var i = 0; i < ids.length; i += 100) {
                (function (chunk) {
                    fetch(url + '?ids=' + chunk.join(','), { headers: { 'Accept': 'application/json' } })
                        .then(function (r) { return r.json(); })
                        .then(function (map) {
                            Object.keys(map).forEach(function (k) { cache[k] = map[k]; });
                            cards.forEach(function (c) {
                                var id = c.getAttribute('data-pid');
                                if (chunk.indexOf(id) !== -1) build(c, cache[id]);
                            });
                        })
                        .catch(function (err) { console.error('product-specs error:', err); });
                })(ids.slice(i, i + 100));
            }
        }

        document.addEventListener('click', function (e) {
            var more = e.target.closest('.eb-spec-more');
            if (more) {
                e.preventDefault();
                e.stopPropagation();
                var drop = more.closest('.eb-spec-drop');
                if (drop) {
                    drop.classList.add('expanded');
                    if (drop._specCard) positionFloating(drop._specCard);
                }
                return;
            }

            var btn = e.target.closest('.eb-sku-link');
            if (btn) {
                e.preventDefault();
                e.stopPropagation();
                var card = btn.closest('.eb-pc');
                if (!card) return;
                if (desktop.matches && card._floatingSpec) {
                    closeAll(card);
                    show(card);
                    return;
                }
                if (card.classList.contains('spec-open')) {
                    reset(card);
                } else {
                    closeAll(card);
                    show(card);
                }
                return;
            }

            if (e.target.closest('.eb-spec-drop')) return;
            closeAll();
        }, true);

        document.addEventListener('mouseout', function (e) {
            if (!desktop.matches || !e.target.closest) return;
            var card = e.target.closest('.eb-pc');
            var floating = e.target.closest('.eb-spec-floating');
            if (!card && floating) card = floating._specCard;
            if (!card || card.contains(e.relatedTarget)) return;
            if (card._floatingSpec && card._floatingSpec.contains(e.relatedTarget)) return;
            reset(card);
        });

        function repositionOpenSpecs() {
            document.querySelectorAll('.eb-pc.spec-open').forEach(positionFloating);
        }
        window.addEventListener('scroll', repositionOpenSpecs, true);
        window.addEventListener('resize', repositionOpenSpecs);

        // Desktop: drag directly on a product card to move its row. Pause the
        // CSS marquee during the gesture so the card does not move under cursor.
        var dragState = null;
        var suppressDraggedClick = null;
        document.addEventListener('mousedown', function (e) {
            if (!desktop.matches || e.button !== 0) return;
            var marquee = e.target.closest && e.target.closest('.eb-prod-marquee');
            if (!marquee || e.target.closest('button,input,select,textarea,.eb-spec-drop')) return;
            var track = marquee.querySelector('.eb-prod-track');
            dragState = { marquee: marquee, track: track, startX: e.clientX, startScroll: marquee.scrollLeft, moved: false };
            marquee.classList.add('eb-mouse-dragging');
            if (track) track.style.animationPlayState = 'paused';
        });
        document.addEventListener('mousemove', function (e) {
            if (!dragState) return;
            var distance = e.clientX - dragState.startX;
            if (Math.abs(distance) > 4) dragState.moved = true;
            if (!dragState.moved) return;
            e.preventDefault();
            dragState.marquee.scrollLeft = dragState.startScroll - distance;
        });
        document.addEventListener('mouseup', function () {
            if (!dragState) return;
            dragState.marquee.classList.remove('eb-mouse-dragging');
            if (dragState.track) dragState.track.style.animationPlayState = '';
            suppressDraggedClick = dragState.moved ? dragState.marquee : null;
            dragState = null;
        });
        document.addEventListener('dragstart', function (e) {
            if (e.target.closest && e.target.closest('.eb-prod-marquee')) e.preventDefault();
        });
        document.addEventListener('click', function (e) {
            if (!suppressDraggedClick) return;
            var draggedMarquee = suppressDraggedClick;
            suppressDraggedClick = false;
            if (!e.target.closest || e.target.closest('.eb-prod-marquee') !== draggedMarquee) return;
            e.preventDefault();
            e.stopPropagation();
        }, true);

        var touchState = null;
        document.addEventListener('touchstart', function (e) {
            var marquee = e.target.closest && e.target.closest('.eb-prod-marquee');
            if (!marquee || !e.touches || e.touches.length !== 1) return;
            var track = marquee.querySelector('.eb-prod-track');
            touchState = {
                marquee: marquee,
                track: track,
                startX: e.touches[0].clientX,
                startY: e.touches[0].clientY,
                startScroll: marquee.scrollLeft,
                moved: false,
                horizontal: false
            };
            if (track) track.style.animationPlayState = 'paused';
        }, { passive: true });
        document.addEventListener('touchmove', function (e) {
            if (!touchState || !e.touches || e.touches.length !== 1) return;
            var dx = e.touches[0].clientX - touchState.startX;
            var dy = e.touches[0].clientY - touchState.startY;
            if (!touchState.horizontal && Math.abs(dx) > 6 && Math.abs(dx) > Math.abs(dy)) {
                touchState.horizontal = true;
                touchState.moved = true;
                touchState.marquee.classList.add('eb-mouse-dragging');
            }
            if (!touchState.horizontal) return;
            if (e.cancelable) e.preventDefault();
            touchState.marquee.scrollLeft = touchState.startScroll - dx;
        }, { passive: false });
        function finishTouchDrag() {
            if (!touchState) return;
            touchState.marquee.classList.remove('eb-mouse-dragging');
            if (touchState.track) touchState.track.style.animationPlayState = '';
            if (touchState.moved) suppressDraggedClick = touchState.marquee;
            touchState = null;
        }
        document.addEventListener('touchend', finishTouchDrag, { passive: true });
        document.addEventListener('touchcancel', finishTouchDrag, { passive: true });

        document.addEventListener('mouseover', function (e) {
            if (!desktop.matches || !e.target.closest) return;
            var card = e.target.closest('.eb-pc.has-spec');
            if (card && !card.contains(e.relatedTarget)) show(card);
        });

        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeAll(); });

        document.addEventListener('DOMContentLoaded', scan);
        window.addEventListener('load', scan);

        var t;
        new MutationObserver(function () {
            clearTimeout(t);
            t = setTimeout(scan, 200);
        }).observe(document.body || document.documentElement, { childList: true, subtree: true });
    })();
</script>
