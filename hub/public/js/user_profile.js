var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

function handleFollowBtn (state) 
{
	var follow_btn = document.getElementById('follow-btn');
	var action = state ? 'follow' : 'unfollow';

	axios.post(window.location.pathname + '/' + action, {})
	.then(
		function(response)
		{
			if (response.data.status == 'success')
			{
				if (action == 'follow')
				{
					document.getElementById('follow-btn-container').innerHTML = '<div class="btn btn-primary" id="follow-btn" onclick="handleFollowBtn(false);">Unfollow</div>';
				}
				else 
				{
					document.getElementById('follow-btn-container').innerHTML = '<div class="btn btn-success" id="follow-btn" onclick="handleFollowBtn(true);">Follow</div>';
				}
			}
		});
}