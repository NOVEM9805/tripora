'use strict';
document.querySelectorAll('[data-email-diagnostics]').forEach(form=>{
  const panel=form.closest('.email-diagnostics'),feedback=panel.querySelector('[data-email-feedback]'),results=panel.querySelector('[data-email-results]');
  const buttons=[...form.querySelectorAll('button')];let pending=false;
  form.addEventListener('submit',async event=>{
    event.preventDefault();if(pending)return;
    pending=true;buttons.forEach(button=>button.disabled=true);results.hidden=true;feedback.textContent=tr('Checking...');
    const request=new AbortController(),timeout=setTimeout(()=>request.abort(),25000);
    try{
      const body=new FormData(form);body.set('mode',event.submitter?.value||'check');
      const response=await fetch(form.action,{method:'POST',body,credentials:'same-origin',signal:request.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(!response.ok||!data.ok)throw new Error(data.message||tr('The email check could not be completed. Please try again.'));
      feedback.textContent=data.message;panel.querySelector('[data-email-account]').textContent=data.email+' · '+data.account;
      panel.querySelector('[data-email-config]').textContent=data.configuration;
      const history=panel.querySelector('[data-email-history]');history.replaceChildren();
      data.deliveries.forEach(delivery=>{
        const row=document.createElement('tr');
        [delivery.created_at,delivery.purpose,delivery.status,delivery.detail].forEach(value=>{const cell=document.createElement('td');cell.textContent=value;row.append(cell);});
        history.append(row);
      });results.hidden=false;
    }catch(error){feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);pending=false;buttons.forEach(button=>button.disabled=false);}
  });
});
