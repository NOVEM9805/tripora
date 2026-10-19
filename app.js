'use strict';
const toggle = document.querySelector('.menu-toggle');
if (toggle) toggle.addEventListener('click', () => {
  const expanded = toggle.getAttribute('aria-expanded') === 'true';
  toggle.setAttribute('aria-expanded', String(!expanded));
  document.getElementById('main-nav').classList.toggle('open', !expanded);
});
document.querySelectorAll('[data-open]').forEach(button => button.addEventListener('click', () => {
  const dialog = document.getElementById(button.dataset.open);
  if (dialog && !dialog.open) dialog.showModal();
}));
document.querySelectorAll('[data-close]').forEach(button => button.addEventListener('click', () => button.closest('dialog').close()));
document.querySelectorAll('dialog').forEach(dialog => dialog.addEventListener('click', event => {
  if(event.target !== dialog) return;
  const box=dialog.getBoundingClientRect();
  if(event.clientX<box.left || event.clientX>box.right || event.clientY<box.top || event.clientY>box.bottom)dialog.close();
}));
document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => {
  if (!window.confirm(form.dataset.confirm)) event.preventDefault();
}));
document.querySelectorAll('form').forEach(form => {
  const checkIn=form.querySelector('[type="date"][name="check_in"]');
  const checkOut=form.querySelector('[type="date"][name="check_out"]');
  if (!checkIn || !checkOut) return;
  checkIn.addEventListener('change', () => {
    if(!checkIn.value)return;
    const d = new Date(checkIn.value+'T00:00:00Z');d.setUTCDate(d.getUTCDate()+1);
    const minimum=d.toISOString().slice(0,10);checkOut.min=minimum;
    if(checkOut.value<minimum)checkOut.value=minimum;
  });
});

// Save in the background. No navigation or page reload follows a successful request.
const pendingStays = new Set();
let toastTimer;
function showSaveMessage(message, isError = false) {
  const toast = document.getElementById('save-toast');
  if (!toast) return;
  toast.textContent = message;
  toast.classList.toggle('is-error', isError);
  toast.classList.add('is-visible');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 4000);
}
function syncSavedState(hotel, saved) {
  document.querySelectorAll('form[data-wishlist]').forEach(form => {
    if (form.dataset.wishlist !== String(hotel)) return;
    const button = form.querySelector('button');
    button.classList.toggle('is-saved', saved);
    button.setAttribute('aria-pressed', String(saved));
    button.setAttribute('aria-label', tr(saved ? 'Unsave stay' : 'Save stay'));
    form.querySelector('[name="saved"]').value = saved ? '0' : '1';
    const label = button.querySelector('[data-save-label]');
    if (label) label.textContent = tr(saved ? 'Saved' : 'Save stay');
    // Keep the card in place so the user can save it again without a page change.
  });
}
document.querySelectorAll('form[data-wishlist]').forEach(form => {
  form.addEventListener('submit', async event => {
    event.preventDefault();
    const hotel = form.dataset.wishlist;
    if (pendingStays.has(hotel)) return;
    pendingStays.add(hotel);
    const matchingButtons = [...document.querySelectorAll('form[data-wishlist]')]
      .filter(item => item.dataset.wishlist === hotel).map(item => item.querySelector('button'));
    matchingButtons.forEach(button => { button.disabled = true; button.setAttribute('aria-busy', 'true'); });
    const controller = new AbortController();
    const timeout = setTimeout(() => controller.abort(), 15000);
    try {
      const body = new FormData(form);
      const response = await fetch(form.dataset.endpoint, {
        method: 'POST', body, credentials: 'same-origin', headers: {'Accept': 'application/json'}, signal: controller.signal
      });
      const data = await response.json();
      if (!response.ok || !data.ok) throw new Error(data.message || tr('Could not update your saved stays.'));
      syncSavedState(data.hotel_id, data.saved);
      showSaveMessage(data.message);
    } catch (error) {
      showSaveMessage(error.name === 'AbortError' ? tr('The request timed out. Try saving this stay again.') : (error.message || tr('Check your connection and try again.')), true);
    } finally {
      clearTimeout(timeout);
      pendingStays.delete(hotel);
      matchingButtons.forEach(button => { button.disabled = false; button.removeAttribute('aria-busy'); });
    }
  });
});

// Background availability, private receipt details and two-way support.
const clientStrings = JSON.parse(document.getElementById('client-strings')?.dataset.json || '{}');
const tr = key => clientStrings[key] || key;
const availabilityForm = document.querySelector('form[data-availability]');
if (availabilityForm) {
  const region = document.getElementById('availability-results');
  const feedback = document.getElementById('availability-feedback');
  const submit = availabilityForm.querySelector('button');
  const originalLabel = submit.textContent;
  let request, revision = 0;
  const invalidate = () => {
    revision++; request?.abort(); region.hidden = true;
    feedback.hidden = false; feedback.className = 'notice info';
    feedback.textContent = tr('Check availability for your new dates.');
    submit.disabled = false; submit.textContent = originalLabel;
  };
  availabilityForm.addEventListener('change', invalidate);
  availabilityForm.addEventListener('submit', async event => {
    event.preventDefault(); request?.abort(); const current = ++revision;
    request = new AbortController(); const controller = request;
    const timeout = setTimeout(() => controller.abort(), 15000);
    const params = new URLSearchParams(new FormData(availabilityForm));
    region.hidden = true; region.setAttribute('aria-busy','true');
    feedback.hidden = false; feedback.className = 'notice info'; feedback.textContent = tr('Checking...');
    submit.disabled = true; submit.textContent = tr('Checking...');
    try {
      const response = await fetch(availabilityForm.dataset.endpoint + '?' + params, {signal: controller.signal,credentials:'same-origin',headers:{Accept:'application/json'}});
      const data = await response.json();
      if (current !== revision) return;
      if (!response.ok || !data.ok) throw new Error(data.message || tr('Could not check availability. Please try again.'));
      region.innerHTML = data.html; region.hidden = false;
      feedback.textContent = data.message; feedback.className = 'notice info';
    } catch (error) {
      if (current !== revision) return;
      feedback.textContent = error.name === 'AbortError' ? tr('The request timed out. Please try again.') : error.message;
      feedback.className = 'notice error';
    } finally {
      clearTimeout(timeout);
      if (current === revision) {submit.disabled=false; submit.textContent=originalLabel; region.removeAttribute('aria-busy');}
    }
  });
}

const receiptDialog = document.getElementById('payment-dialog');
if (receiptDialog) {
  let receiptRequest, receiptRevision=0;
  const image = receiptDialog.querySelector('[data-receipt-image]');
  const feedback = receiptDialog.querySelector('[data-receipt-feedback]');
  const layout = receiptDialog.querySelector('.receipt-layout');
  const zoom = receiptDialog.querySelector('[data-zoom-receipt]');
  receiptDialog.addEventListener('close', () => {receiptRevision++; receiptRequest?.abort();});
  document.addEventListener('click', async event => {
    const link=event.target.closest('[data-receipt]'); if(!link) return;
    event.preventDefault(); receiptRequest?.abort(); const current=++receiptRevision;
    receiptRequest=new AbortController(); const controller=receiptRequest;
    const timeout=setTimeout(()=>controller.abort(),15000);
    layout.hidden=true; image.hidden=true; image.removeAttribute('src'); image.classList.remove('is-zoomed');
    zoom.textContent=tr('Zoom screenshot'); feedback.textContent=tr('Loading payment details...');
    if(!receiptDialog.open)receiptDialog.showModal();
    try {
      const response=await fetch(link.dataset.endpoint+'?id='+encodeURIComponent(link.dataset.receipt),{signal:controller.signal,credentials:'same-origin',headers:{Accept:'application/json'}});
      const data=await response.json(); if(current!==receiptRevision)return;
      if(!response.ok||!data.ok)throw new Error(data.message||tr('Could not load payment details. Please try again.'));
      receiptDialog.querySelectorAll('[data-payment-field]').forEach(field=>{field.textContent=data.payment[field.dataset.paymentField]||'—';});
      feedback.textContent=''; layout.hidden=false;
      image.onload=()=>{if(current===receiptRevision)image.hidden=false;};
      image.onerror=()=>{if(current===receiptRevision)feedback.textContent=tr('Screenshot could not be loaded.');};
      image.src=data.payment.image;
    } catch(error){if(current===receiptRevision)feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);}
  });
  zoom.addEventListener('click',()=>{const expanded=image.classList.toggle('is-zoomed');zoom.textContent=tr(expanded?'Fit screenshot':'Zoom screenshot');});
}

function updateThreads(threads){
  const list=document.querySelector('[data-admin-inbox]'); if(!list)return;
  if(threads.length)list.querySelector('.threads-empty')?.remove();
  threads.forEach(item=>{
    let link=list.querySelector('[data-thread="'+Number(item.id)+'"]');
    if(!link){
      link=document.createElement('a');link.className='thread-item';link.dataset.thread=item.id;
      const url=new URL(location.href);url.searchParams.set('thread_id',item.id);link.href=url;
      link.append(document.createElement('strong'),document.createElement('small'));
      const badge=document.createElement('span');badge.className='badge';badge.dataset.unread='';link.append(badge);
    }
    link.querySelector('strong').textContent=item.customer_name;link.querySelector('small').textContent=item.email;link.querySelector('[data-unread]').textContent=item.unread;
    list.append(link);
  });
}
const chat=document.querySelector('[data-chat]');
const inbox=document.querySelector('[data-admin-inbox]');
if(inbox&&!chat){
  let busy=false, stopped=false;
  async function pollInbox(){
    if(busy||stopped||document.hidden)return;
    busy=true;const controller=new AbortController(),timeout=setTimeout(()=>controller.abort(),12000);
    try{
      const response=await fetch(inbox.dataset.endpoint+'?inbox=1',{credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(response.ok&&data.ok&&!stopped)updateThreads(data.threads);
    }catch(error){/* Retry when the connection returns. */}finally{clearTimeout(timeout);busy=false;}
  }
  pollInbox();const inboxTimer=setInterval(pollInbox,4000);
  document.addEventListener('visibilitychange',()=>{if(!document.hidden)pollInbox();});
  window.addEventListener('pagehide',()=>{stopped=true;clearInterval(inboxTimer);});
}
if(chat){
  const history=chat.querySelector('.chat-history'), form=chat.querySelector('.chat-form'), feedback=chat.querySelector('.chat-feedback');
  const textarea=form.querySelector('textarea'), sendButton=form.querySelector('button');
  const nonce=form.querySelector('[name="client_nonce"]'), myRole=document.body.dataset.role;
  let last=Number(chat.dataset.last), polling=false, sending=false, timer, destroyed=false;
  const rendered=new Set([...history.querySelectorAll('[data-message]')].map(item=>String(item.dataset.message)));
  const newNonce=()=>Array.from(crypto.getRandomValues(new Uint8Array(16)),b=>b.toString(16).padStart(2,'0')).join('');
  function applyMessages(data){
    const atBottom=history.scrollHeight-history.scrollTop-history.clientHeight<80;
    data.messages.forEach(message=>{
      last=Math.max(last,Number(message.id)); if(rendered.has(String(message.id)))return;
      rendered.add(String(message.id)); history.querySelector('.chat-empty')?.remove();
      const bubble=document.createElement('article');bubble.className='chat-bubble'+(message.sender_role===myRole?' mine':'');bubble.dataset.message=message.id;
      const name=document.createElement('strong');name.textContent=message.sender_role==='admin'?data.team_label:message.sender_name;
      const body=document.createElement('p');body.textContent=message.body;
      const time=document.createElement('time');time.textContent=message.created_at+' UTC';bubble.append(name,body,time);history.append(bubble);
    });
    if(atBottom||sending)history.scrollTop=history.scrollHeight;
    chat.querySelector('[data-chat-status]').textContent=data.status;
    if(data.threads)updateThreads(data.threads);
  }
  async function poll(){
    if(destroyed||polling||document.hidden)return;
    polling=true; const controller=new AbortController(), timeout=setTimeout(()=>controller.abort(),12000);
    try{
      const params=new URLSearchParams({thread_id:chat.dataset.chat,after:String(last)});
      const response=await fetch(chat.dataset.endpoint+'?'+params,{credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(!response.ok||!data.ok)throw new Error(data.message||tr('Connection interrupted. Retrying...'));
      applyMessages(data);if(!sending)feedback.textContent='';
      if(data.has_more)setTimeout(poll,0);
    }catch(error){if(!sending)feedback.textContent=error.name==='AbortError'?tr('Connection interrupted. Retrying...'):error.message;}
    finally{clearTimeout(timeout);polling=false;}
  }
  form.addEventListener('submit',async event=>{
    event.preventDefault();if(sending||!textarea.value.trim())return;
    sending=true;sendButton.disabled=true;feedback.textContent=tr('Sending...');
    const controller=new AbortController(),timeout=setTimeout(()=>controller.abort(),15000);
    const body=new FormData(form);body.set('action','send');body.set('after',String(last));
    textarea.disabled=true;
    try{
      const response=await fetch(chat.dataset.endpoint,{method:'POST',body,credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(!response.ok||!data.ok)throw new Error(data.message||tr('Your message could not be sent. Please try again.'));
      applyMessages(data);textarea.value='';nonce.value=newNonce();feedback.textContent=tr('Message sent.');
    }catch(error){feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);sending=false;sendButton.disabled=false;textarea.disabled=false;textarea.focus();}
  });
  document.querySelector('[data-resolve-chat]')?.addEventListener('click',async event=>{
    event.target.disabled=true;
    try{
      const body=new FormData(form);body.set('action','resolve');body.set('after',String(last));
      const response=await fetch(chat.dataset.endpoint,{method:'POST',body,credentials:'same-origin'});const data=await response.json();
      if(!response.ok||!data.ok)throw new Error(data.message);applyMessages(data);
    }catch(error){feedback.textContent=error.message;}finally{event.target.disabled=false;}
  });
  history.scrollTop=history.scrollHeight;poll();timer=setInterval(poll,4000);
  document.addEventListener('visibilitychange',()=>{if(!document.hidden)poll();});
  window.addEventListener('pagehide',()=>{destroyed=true;clearInterval(timer);});
}

// Paste/autofill the entire code, or enter one digit at a time. No automatic submission.
document.querySelectorAll('[data-otp]').forEach(group=>{
  const digits=[...group.querySelectorAll('.otp-digit')],code=group.querySelector('[data-otp-code]');
  const numbers=value=>value.replace(/[၀-၉]/g,ch=>String(ch.charCodeAt(0)-0x1040)).replace(/[^0-9]/g,'');
  const sync=()=>{code.value=digits.map(field=>field.value).join('');};
  const fill=(value,index)=>{
    const clean=numbers(value);if(!clean)return;
    const start=clean.length>=digits.length?0:index;
    [...clean.slice(0,digits.length-start)].forEach((digit,offset)=>{digits[start+offset].value=digit;});
    sync();const next=Math.min(start+clean.length,digits.length-1);digits[next].focus();digits[next].select();
  };
  digits.forEach((field,index)=>{
    field.addEventListener('input',()=>{
      const clean=numbers(field.value);
      if(clean.length>1){fill(clean,index);return;}
      field.value=clean;sync();
      if(clean&&index<digits.length-1){digits[index+1].focus();digits[index+1].select();}
    });
    field.addEventListener('paste',event=>{const text=event.clipboardData?.getData('text')||'';event.preventDefault();fill(text,index);});
    field.addEventListener('keydown',event=>{
      if(event.key==='Backspace'&&!field.value&&index>0){event.preventDefault();digits[index-1].value='';digits[index-1].focus();sync();}
      if(event.key==='ArrowLeft'&&index>0){event.preventDefault();digits[index-1].focus();digits[index-1].select();}
      if(event.key==='ArrowRight'&&index<digits.length-1){event.preventDefault();digits[index+1].focus();digits[index+1].select();}
    });
  });
});
const profileForm=document.querySelector('[data-profile-form]');
if(profileForm){
  const input=profileForm.querySelector('[data-profile-photo]'),preview=profileForm.querySelector('[data-profile-preview]'),placeholder=profileForm.querySelector('[data-profile-placeholder]');
  const remove=profileForm.querySelector('[data-remove-photo]'),feedback=profileForm.querySelector('[data-photo-feedback]');
  const original=preview.getAttribute('src');let photoRevision=0;
  const restore=()=>{if(original)preview.src=original;preview.hidden=!original;placeholder.hidden=!!original;};
  input.addEventListener('change',()=>{
    const current=++photoRevision,file=input.files[0];feedback.textContent='';
    if(!file){restore();return;}
    if(!['image/jpeg','image/png','image/webp'].includes(file.type)||file.size>5*1024*1024){input.value='';restore();feedback.textContent=tr('Upload a JPG, PNG or WebP image up to 5 MB.');return;}
    if(remove)remove.checked=false;
    const reader=new FileReader();reader.onload=()=>{if(current!==photoRevision)return;preview.src=reader.result;preview.hidden=false;placeholder.hidden=true;};reader.readAsDataURL(file);
  });
  remove?.addEventListener('change',()=>{photoRevision++;input.value='';feedback.textContent='';if(remove.checked){preview.hidden=true;placeholder.hidden=false;}else restore();});
}

// Resend stays on the verification page; the countdown follows server cooldowns.
document.querySelectorAll('[data-otp-resend]').forEach(form=>{
  const button=form.querySelector('button'),counter=form.querySelector('[data-resend-countdown]'),feedback=form.querySelector('[data-resend-feedback]');
  const otp=document.querySelector('[data-otp]'),verifyButton=otp?.closest('form')?.querySelector('button');
  let deadline=Date.now()+Number(form.dataset.retryAfter||0)*1000,pending=false,timer=null,request,away=false;
  function tick(){
    const seconds=Math.max(0,Math.ceil((deadline-Date.now())/1000));
    button.hidden=seconds>0;counter.hidden=seconds===0;
    if(seconds){const clock=String(Math.floor(seconds/60)).padStart(2,'0')+':'+String(seconds%60).padStart(2,'0');counter.textContent=tr('Send a new code in')+' '+clock;}
    else if(timer!==null){clearInterval(timer);timer=null;}
  }
  function countdown(seconds){
    deadline=Date.now()+Math.max(0,Number(seconds)||0)*1000;tick();
    if(deadline>Date.now()&&timer===null)timer=setInterval(tick,1000);
  }
  countdown(Number(form.dataset.retryAfter||0));
  form.addEventListener('submit',async event=>{
    event.preventDefault();if(pending||deadline>Date.now())return;
    pending=true;button.disabled=true;if(verifyButton)verifyButton.disabled=true;feedback.textContent=tr('Sending...');
    request=new AbortController();const controller=request,timeout=setTimeout(()=>controller.abort(),20000);
    try{
      const response=await fetch(form.dataset.endpoint,{method:'POST',body:new FormData(form),credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(away)return;
      if(Number(data.retry_after)>0)countdown(data.retry_after);
      if(!response.ok||!data.ok)throw new Error(data.message||tr('The code could not be sent. Please try again.'));
      feedback.textContent=data.message;
      otp?.querySelectorAll('.otp-digit').forEach(field=>{field.value='';});
      const code=otp?.querySelector('[data-otp-code]');if(code)code.value='';
    }catch(error){if(!away)feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);pending=false;button.disabled=false;if(verifyButton)verifyButton.disabled=false;}
  });
  document.addEventListener('visibilitychange',()=>{if(!document.hidden)tick();});
  window.addEventListener('pagehide',()=>{away=true;request?.abort();if(timer!==null){clearInterval(timer);timer=null;}});
  window.addEventListener('pageshow',()=>{away=false;tick();if(deadline>Date.now()&&timer===null)timer=setInterval(tick,1000);});
});

// Each row opens its own record immediately; stale forms stay hidden while loading.
const recordEditor=document.querySelector('[data-record-editor]');
if(recordEditor){
  const form=recordEditor.querySelector('[data-record-form]'),mode=recordEditor.querySelector('[data-record-mode]'),summary=recordEditor.querySelector('[data-record-summary]');
  const number=recordEditor.querySelector('[data-record-number]'),feedback=recordEditor.querySelector('[data-record-feedback]');
  let request,revision=0;
  const show=()=>{if(!recordEditor.open)recordEditor.showModal();};
  function populate(record){
    form.querySelectorAll('[data-record-field]').forEach(field=>{
      const key=field.dataset.recordField,type=field.dataset.fieldType;
      if(type==='image')field.value='';
      else if(type==='bool')field.checked=record?Number(record[key])===1:key==='active';
      else field.value=record?(record[key]??''):(type==='id'?'0':'');
    });
    form.querySelectorAll('[data-record-remove]').forEach(field=>{field.checked=false;});
    form.querySelectorAll('[data-record-photo]').forEach(image=>{
      const src=record?.photo_urls?.[image.dataset.recordPhoto]||'';
      image.hidden=!src;if(src)image.src=src;else image.removeAttribute('src');
    });
    if(!record){const country=document.querySelector('[data-catalogue-country]'),destination=document.querySelector('[data-catalogue-destination]');
      const parent=form.querySelector('[data-record-field="country_id"]')||form.querySelector('[data-record-field="destination_id"]');
      if(parent)parent.value=parent.dataset.recordField==='country_id'?(country?.value||''):(destination?.value||'');
    }
    mode.textContent=tr(record?'Edit':'Add');summary.hidden=!record;number.textContent=record?record.id:'';
    feedback.textContent='';form.hidden=false;
    if(typeof recordEditor.dispatchEvent==='function')recordEditor.dispatchEvent(new CustomEvent('tripora:record-populated',{detail:{record}}));
  }
  recordEditor.addEventListener('close',()=>{revision++;request?.abort();});
  document.querySelectorAll('[data-record-add]').forEach(button=>button.addEventListener('click',()=>{revision++;request?.abort();populate(null);show();}));
  async function editRecord(id){
    if(typeof recordEditor.dispatchEvent==='function')recordEditor.dispatchEvent(new CustomEvent('tripora:record-loading'));
    request?.abort();const current=++revision;request=new AbortController();
    const controller=request,timeout=setTimeout(()=>controller.abort(),15000);
    form.hidden=true;summary.hidden=true;mode.textContent=tr('Edit');feedback.textContent=tr('Loading record...');show();
    try{
      const params=new URLSearchParams({entity:recordEditor.dataset.entity,id:String(id)});
      const response=await fetch(recordEditor.dataset.endpoint+'?'+params,{credentials:'same-origin',signal:controller.signal,headers:{Accept:'application/json'}});
      const data=await response.json();if(current!==revision)return;
      if(!response.ok||!data.ok)throw new Error(data.message||tr('Could not load this record. Please try again.'));
      populate(data.record);
    }catch(error){if(current===revision)feedback.textContent=error.name==='AbortError'?tr('The request timed out. Please try again.'):error.message;}
    finally{clearTimeout(timeout);}
  }
  document.querySelectorAll('[data-record-edit]').forEach(link=>link.addEventListener('click',event=>{event.preventDefault();return editRecord(link.dataset.recordId);}));
  recordEditor.addEventListener('tripora:edit-record',event=>editRecord(event.detail.id));
  if(Number(recordEditor.dataset.initialEdit)>0){if(recordEditor.open)recordEditor.close();show();}
}
