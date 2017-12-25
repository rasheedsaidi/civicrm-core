<h3>Membership</h3>
{$membership.contact_id.first_name}
{if $membership}
  {strip}
      {* handle enable/disable actions *}
      {include file="CRM/common/enableDisableApi.tpl"}
      {include file="CRM/common/jsortable.tpl"}
      <table id="options" class="display">
        <tbody>
        <tr>
          <td>{ts}Member{/ts}</td>
          <td>{ $membership.name }</td>
        </tr>
        <tr>
          <td>{ts}Membership Type{/ts}</td>
          <td>{ $membership.membership_type_name }</td>
        </tr>
        <tr>
          <td>{ts}Status{/ts}</td>
          <td>{ $membership.status }</td>
        </tr>
        <tr>
          <td>{ts}Start Date{/ts}</td>
          <td>{ $membership.start_date }</td>
        </tr>
        <tr>
          <td>{ts}Expiration Date{/ts}</td>
          <td>{ $membership.end_date }</td>
        </tr>
        </tbody>
      </table>
      {if $contribution}
      <h3>Related contribution</h3>
      <table>
      	<thead>
      		<th>{ts}Amount{/ts}</th>
      		<th>{ts}Source{/ts}</th>
      		<th>{ts}Received date{/ts}</th>
      		<th>{ts}Payment method{/ts}</th>
      		<th>{ts}Status{/ts}</th>
      	</thead>
      	<tbody>
        {* foreach from=$contributions item=contribution *}
          <tr>            
            <td>{$contribution.amount}</td>
            <td>{$contribution.source}</td>
            <td>{$contribution.receive_date|crmDate}</td>
            <td>{$contribution.payment_method}</td>
            <td>{$contribution.status}</td>
          </tr>
        {* /foreach *}
    	</tbody>
      </table>
      {/if}
    {/strip}
    {/if}

