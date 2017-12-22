<h3>This contant has {$total} term{$s}</h3>

<div class="crm-block crm-content-block">

  {if $total < 1}
  <div class="row">
    <div class="alert alert-info">No terms recorded for this contact's membership</div>
  </div>
  {/if}

  {if $total >= 1}
  {strip}
      {* handle enable/disable actions *}
      {include file="CRM/common/enableDisableApi.tpl"}
      {include file="CRM/common/jsortable.tpl"}
      <table id="options" class="display">
        <thead>
        <tr>
          <th>{ts}Start Date{/ts}</th>
          <th>{ts}End Date{/ts}</th>
          <th>&nbsp;</th>
        </tr>
        </thead>
        {foreach from=$result.values item=membershipterm}
          <tr>            
            <td>{$membershipterm.start_date|crmDate}</td>
            <td>{$membershipterm.end_date|crmDate}</td>
            <td><a class="crm-popup" href='{crmURL p='civicrm/membershipterm/view/contribution' q="cid=`$membershipterm.contact_id`&reset=1"}'>View contribution</a></td>
          </tr>
        {/foreach}
      </table>
    {/strip}
    {/if}
</div>
