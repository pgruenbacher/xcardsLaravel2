@extends('layout.frontpage')
@section('header')
<style>
	.question{
		font-weight: 600;
		font-size:18px;
	}
</style>
@stop
@section('content')
<div class="container">
	<div class="col-md-8">
		<div id="small-print">
			<h1>Privacy Policy</h1>
			<p>We recommend reading this privacy policy for X-Press Cards, which includes the Privacy Policy for the X-Press Cards website, and mobile app. For more information on how we collect, use, share, and secure information please contact us at info@X-PressCards.com. The following provides a summary of some of the most important aspects of our privacy policy:  </p>
			<ul>
				<li>We only use your personal information to provide you with products and to create a superior service for you.</li>
				<li>We take reasonable measures to secure your sensitive personal information, but we cannot promise, and you should not expect, that your sensitive personal information will remain secure in all circumstances.</li>
				<li>We do not sell, rent, or share your personal information for others to market to you without your permission.</li>
				<li>X-Press Cards takes your credit card information very seriously.  Therefore we go though a third-party online payment company.  We never store or see any of your credit card information.</li>
			</ul>
			<div class="question">
				<p>What information do we collect?</p>
			</div>
			<div class="answer">
				<p>We collect information from you when you register on our site, place an order or subscribe to our newsletter. We never see or store any credit card information.</p>
				<p>When ordering or registering on our site, as appropriate, you may be asked to enter your: name, e-mail address, mailing address or phone number.</p>
			</div>
			<div class="question">
				<p>What do we use your information for?</p>
			</div>
			<div class="answer">
				<ol>
					<li><p>To personalize your experience</p>
						<p>Our goal is to only collect information that helps us to better respond to your individual needs.</p>
					</li>
					<li>
						<p>To improve our website</p>
						<p>We continually strive to create a superior website based on the information and feedback we receive from you.</p>
					</li>
					<li>
						<p>To process transactions</p>
						<p>Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</p>
					</li>
					<li>
						<p>To send periodic emails</p>
						<p>The email address you provide for order processing, may be used to send you information and updates pertaining to your order, in addition to receiving occasional company news, updates, related product or service information, etc.</p>
						<p>Note: If at any time you would like to unsubscribe from receiving future emails, we include detailed unsubscribe instructions at the bottom of each email.</p>
					</li>
				</ol>
			</div>
			<div class="question">
				<p>How do we protect your information?</p>
			</div>
			<div class="answer">
				<p>We implement a variety of security measures to maintain the safety of your personal information when you place an order or enter, submit, or access your personal information.</p>
				<p>We offer the use of a secure server. All supplied sensitive/credit information is transmitted via Secure Socket Layer (SSL) technology and then encrypted into our Payment gateway providers database only to be accessible by those authorized with special access rights to such systems, and are required to keep the information confidential.</p>
				<p>After a transaction, your private information (credit cards, social security numbers, financials, etc.) will not be stored on our servers.</p>
			</div>
			<div class="question">
				<p>Do we use cookies?</p>
			</div>
			<div class="answer">
				<p>Yes (Cookies are small files that a site or its service provider transfers to your computers hard drive through your Web browser (if you allow) that enables the sites or service providers systems to recognize your browser and capture and remember certain information</p>
				<p>We use cookies to help us remember and process the items in your shopping cart and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>
			</div>
			<di class="question">
				<p>Do we disclose any information to outside parties?</p>
			</di>
			<div class="answer">
				<p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>
			</div>
			<div class="question">
				<p>California Online Privacy Protection Act Compliance</p>
			</div>
			<div class="answer">
				<p>Because we value your privacy we have taken the necessary precautions to be in compliance with the California Online Privacy Protection Act. We therefore will not distribute your personal information to outside parties without your consent.</p>
				<p>As part of the California Online Privacy Protection Act, all users of our site may make any changes to their information at anytime by logging into their account and going to the 'Edit Profile' page.</p>
			</div>
			<div class="question">
				<p>Childrens Online Privacy Protection Act Compliance</p>
			</div>
			<div class="answer">
				<p>We are in compliance with the requirements of COPPA (Childrens Online Privacy Protection Act), we do not collect any information from anyone under 13 years of age. Our website, products and services are all directed to people who are at least 13 years old or older.</p>
			</div>
			<div class="question">
				<p>Online Privacy Policy Only</p>
			</div>
			<div class="answer">
				<p>This online privacy policy applies only to information collected through our website and not to information collected offline.</p>
			</div>
			<div class="question">
				<p>Terms and Conditions</p>
			</div>
			<div class="answer">
				<p>Please also visit our <a href="{{URL::route('website-terms')}}">Terms and Conditions</a> section establishing the use, disclaimers, and limitations of liability governing the use of our website</p>
			</div>
			<div class="question">
				<p>Your Consent </p>
			</div>
			<div class="answer">
				<p>By using our site, you consent to our websites privacy policy.</p>
			</div>
			<div class="question">
				<p>Changes to our Privacy Policy</p>
			</div>
			<div class="answer">
				<p>If we decide to change our privacy policy, we will update the Privacy Policy modification date below.</p>
				<p>Last updated: June 3, 2014</p>
			</div>
			<div class="question">
				<p>Contacting Us</p>
			</div>
			<div class="answer">
				<p>If there are any questions regarding this privacy policy you may contact us using the information below.</p>
			</div>
			<address>
				<strong>X-Press Cards LLC</strong></br>
				2392 Indiana Ave</br>
				Columbus, OH 43202</br>
			</address>
		</div>
	</div>
</div>

@stop
@section('footer')

@stop
