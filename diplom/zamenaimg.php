<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
	$('img').mouseenter(function() {
		$('.ads').css('opacity', '0.5');
		$('.upblock').css('display', 'block');
		return false;
	});
});
$(document).ready(function() {
	$('.ads').mouseover(function() {
		$('.ads').css('opacity', '1');
		$('.upblock').css('display', 'none');
		return false;
	});
});
</script>
</head>
<body>

<div class="content" style="max-width:800px">
Amid a tense stand-off and attempt at negotiations, Russia’s communications regulator Roskomnadzor has started to enforce a proposed block of LinkedIn in the country, after the social network failed to transfer Russian user data to servers located in the country, violating a law instituted in Russia requiring all online sites to store personal data on national servers.

The order against LinkedIn was issued in a short statement on Roskomnadzor’s site (in Russian) — flagged to us by reader Ilya Pestov, CMO at Statsbot — that cited the original Moscow District Court decision from August to block LinkedIn, along with the more recent case from November 10, in a Moscow City Court, to uphold that decision.

LinkedIn has confirmed the block to us in a statement:

“LinkedIn’s vision is to create economic opportunity for the entire global workforce. We are starting to hear from members in Russia that they can no longer access LinkedIn,” said a spokesperson. “Roskomnadzor’s action to block LinkedIn denies access to the millions of members we have in Russia and the companies that use LinkedIn to grow their businesses. We remain interested in a meeting with Roskomnadzor to discuss their data localization request.”

The ban comes after LinkedIn — which is currently being acquired by Microsoft for $26.2 billion, although that deal is seeing some of its own regulatory hiccups — tried to meet with Russian regulators on Friday, November 11, in a last-minute attempt to hold off the ban, which will see ISPs in Russia forced to comply with the block in coming hours or else face heavy fines and potentially blocks of their own.

<div class="adblock">
	<div class="upblock">
		<a href="#">
		<img class="aligncenter im" src="2.jpg" alt="kartinka2" width="100" height="100">
		<span class="ssilka">Ссылка на какаю-то хрень</span>
		</a>
	</div>
<div class="ads">
<img class="aligncenter myimg" src="1.jpg" alt="kartinka">
</div>
</div>
The statement they gave us last week, combined with what we know today, seems to imply that LinkedIn never got that meeting.

“LinkedIn’s vision is to create economic opportunity for the entire global workforce,” a spokesperson told TechCrunch last week. “The Russian court’s decision has the potential to deny access to LinkedIn for the millions of members we have in Russia and the companies that use LinkedIn to grow their businesses. We have on Friday (11 Nov) again requested a meeting with Roskomnadzor to discuss their data localization request and we understand they are reviewing this proposal at the present time.”

It’s not clear if LinkedIn hoped to buy more time to comply with the ruling, or if they were hoping to somehow negotiate an exception to the law. (We’ve asked, and will update if and when we get a reply.)

There is a precedent for LinkedIn choosing to comply and perhaps asking for more time. When LinkedIn launched in China, it did so by building essentially a completely separate site, with data hosted within the country, in order to meet similar regulatory requirements. Others that have done this include Evernote.

<style>
/* При изменении ads opacity на 1 и добавив в upblock display: none;  - блок пропадает */
.myimg {

}

.adblock {
    width: 100%;
}

img.aligncenter.myimg, .im {
    display: block;
    margin: auto;
}
.upblock {
    text-align: center;
    position: absolute;
    height: inherit;
    left: 24%;
    bottom: 30%;
    opacity: 1;
    z-index: 100;
	display: none;
}
.ads {
    opacity: 1;
}
</style>
</body>
</html>