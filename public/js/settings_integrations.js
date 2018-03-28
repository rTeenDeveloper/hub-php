var token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

function removeIntegration (tag)
{
	var integrationName = tag.dataset.integration;
	if (confirm('Are you sure you want to remove ' + integrationName.charAt(0).toUpperCase() + 
		integrationName.slice(1) + ' integration?')) /* this spaghetti code returns integration name with 
		* first letter uppercased */
	{
		axios.post('/integration/github/remove', {})
		.then(function()
		{
			location.reload();
		})
	}
}