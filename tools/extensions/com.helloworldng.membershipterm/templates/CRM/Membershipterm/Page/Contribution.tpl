<h3>Contribution</h3>

<div class="crm-block crm-content-block">

  {if $contributions}

  {strip}
      {* handle enable/disable actions *}
      {include file="CRM/common/jsortable.tpl"}
      <table id="options" class="display">
        <thead>
        <tr>
          <th>{ts}Total Amount{/ts}</th>
          <th>{ts}Contribution Status{/ts}</th>
          <th>{ts}Payment Instrument{/ts}</th>
          <th>{ts}Status{/ts}</th>
        </tr>
        </thead>
        {foreach from=$contributions.values item=contribution}
          <tr>            
            <td>{$contribution.total_amount}</td>
            <td>{$contribution.contribution_source}</td>
            <td>{$contribution.payment_instrument}</td>
            <td>{$contribution.contribution_status}</td>
          </tr>
        {/foreach}
      </table>
    {/strip}
    {/if}
    {if !$contributions}
    <div class="row">
      <div class="alert alert-info">No contributions recorded for this contact's membership</div>
    </div>
  {/if}

</div>