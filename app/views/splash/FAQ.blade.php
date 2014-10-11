@extends('layout.frontpage')
@section('header')
<style>
	div.questions{
		max-width:900px;
	}
	div.question{
		font-weight:100;
		font-size:large;
		color:blue;
	}
</style>
@stop
@section('content')
<div class="container">
	<h1>Frequently Asked Questions</h1>
	
	<form method="POST" action="{{URL::to('oauth/access_token')}}">
			<input name='grant_type' value='password'>
			<input name='username' type="text">
			<input name='password' type="password">
			<input name='client_id' type="text">
			<input name='client_secret' type="text">
			<input name='scope'>
			<input name='state'>
			<button type="submit">Submit</button>
		</form>
	<div class="links">
		<li><a href="#question1">Brutus Coniculus</a></li>
		<li><a href="#question2">Postcard not received or sent</a></li>
		<li><a href="#question3">I received a postcard and want to send one back</a></li>
		<li><a href="#question4">Security Precautions</a></li>
		<li><a href="#question5">Why do you need my address?</a></li>
		<li><a href="#question6">Address not verified</a></li>
		<li><a href="#question7">Postcard received included profanity</a></li>
		<li><a href="#question8">I don't want to receive any postcards</a></li>
	</div>
	<div class="questions">
		<div id="question1">
			<div class="question">
				<p>Can I take Brutus Coniculus home with me?</p>
			</div>
			<div class="answer">
				<p>No. As much as we would love to have you share the wisdom that Brutus gives us, we can not sell him. Brutus is a dear friend of ours and a critical part of the team. Do not let this stop you from sending Brutus a postcard. You can send them on Brutus's page. You will go on the Wall of Fame and be entered to win monthly prizes! (if he doesn't eat your postcard first)</p>
			</div>
		</div>
		<div id="question2">
			<div class="question">
				<p>I sent a postcard and the recipient never received it. What happened?</p>
			</div>
			<div class="answer">
				<p>Even though X-Press Cards tries to send out the postcards as fast as possible there may be delays with the USPS delievery. If your postcard did not get delievered within 5 business days, contact us at help@X-presscards.com. We'd be happy to make the situation better.</p>
			</div>
		</div>
		<div id="question3">
			<div class="question">
				<p>I received a postcard and want to send one back. How do I do this? </p>
			</div>
			<div class="answer">
				<p>To reply to a postcard, go to Make a Card and enter the 7 digit code that is on the postcard you received. This will automatically send it back to the user you received it from!</p>
			</div>
		</div>
		<div id="question4">
			<div class="question">
				<p>What security precautions do you take?</p>
			</div>
			<div class="answer">
				<p>We take your personal information security very seriously. We do not store and credit card information. We frequently audit our user database to make sure no one takes advantage of our service.</p>
			</div>
		</div>
		<div id="question5">
			<div class="question">
				<p>Why do you need my street address to register an account?</p>
			</div>
			<div class="answer">
				<p>Obviously in the event of mailing your cards to you, we would also like your address so that users can reply to postcards that you send them.  We will notify you via social media if another user asks for your address to send a postcard. We will never sell or give this information to anyone else.</p>
			</div>
		</div>
		<div id="question6">
			<div class="question">
				<p>My street address is not showing up as verified. What should I do?</p>
			</div>
			<div class="answer">
				<p>Well thats no fun! We validate using SmartyStreet Services, but sometimes your address may not be registered. We'll still be able to use the address you give us nonetheless if it's truly correct. Contact us at help@X-PressCards.com and we will try to fix it as quick as we can.</p>
			</div>
		</div>
		<div id="question7">
			<div class="question">
				<p>I received a postcard that included profanity, what should I do?</p>
			</div>
			<div class="answer">
				<p>Please contact us at help@X-PressCards.com ASAP so we can take care of this matter. Sending any profanity or adult material using this service is against our Terms of Service. We try to screen all images and text to make sure this is the case.</p>
			</div>
		</div>
		<div id="question8">
			<div class="question">
				<p>I don't want to receive any postcards. Can you add me to a no mailing list?</p>
			</div>
			<div class="answer">
				<p>Of course we can, contact us at help@X-PressCards.com and we will make sure you no longer receive any postcards. Please include your full mailing address.</p>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer')


@stop
