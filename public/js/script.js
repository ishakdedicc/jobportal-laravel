document.querySelector('#hamburger')?.addEventListener('click', function () {
  const menu = document.getElementById('mobile-menu');
  menu.classList.toggle('hidden');
});

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[id$="-alert"]').forEach(alert => {
    const duration = parseInt(alert.dataset.duration, 10) || 3000;

    alert.style.opacity = '1';
    alert.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
    alert.style.transform = 'translateX(0)';

    setTimeout(() => {
      alert.style.opacity = '0';
      alert.style.transform = 'translateX(20px)';

      setTimeout(() => {
        alert.remove();
      }, 400);
    }, duration);
  });
});

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('mobile-menu');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !toggle.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const menu = document.getElementById('mobile-menu');

    if (hamburger && menu) {
        hamburger.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('applyModal');
  const openBtn = document.querySelector('[data-open-apply]');
  const closeBtn = document.getElementById('closeApply');
  const form = document.getElementById('applyForm');
  const errorBox = document.getElementById('applyError');
  const successBox = document.getElementById('applySuccess');
  const submitBtn = document.getElementById('submitApplicationBtn');

  if (openBtn) {
    openBtn.addEventListener('click', () => {
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  }

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    });
  }

  if (!form) return;

  const apiToken = document
    .querySelector('meta[name="api-token"]')
    ?.getAttribute('content');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    errorBox.classList.add('hidden');
    successBox.classList.add('hidden');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Submitting...';

    const jobId = form.dataset.jobId;
    const formData = new FormData(form);

    try {
      if (!apiToken) {
        throw new Error('Unauthenticated: missing API token. Log out and log in again.');
      }

      const res = await fetch(`/api/jobs/${jobId}/apply`, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Authorization': `Bearer ${apiToken}`
        },
        body: formData
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        // Laravel validation errors (422)
        if (res.status === 422) {
          const first =
            data?.message ||
            Object.values(data?.errors || {}).flat()?.[0] ||
            'Validation failed.';
          throw new Error(first);
        }

        throw new Error(data.message || `Request failed (${res.status})`);
      }

      successBox.innerText = data.message || 'Application submitted successfully';
      successBox.classList.remove('hidden');
      form.reset();

      setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        location.reload();
      }, 1500);

    } catch (err) {
      errorBox.innerText = err.message;
      errorBox.classList.remove('hidden');
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerText = 'Submit Application';
    }
  });
});

document.addEventListener('click', async (e) => {
  const el = e.target.closest('[data-delete-applicant]');
  if (!el) return;

  e.preventDefault();
  e.stopPropagation();
  e.stopImmediatePropagation();

  if (!confirm('Delete this applicant?')) return;

  const apiToken = document.querySelector('meta[name="api-token"]')?.content;
  if (!apiToken) {
    alert('Unauthenticated. Log out and log in again.');
    return;
  }

  const applicantId = el.dataset.applicantId;

  const url = new URL(`/api/applicants/${applicantId}`, window.location.origin).toString();

  try {
    const res = await fetch(url, {
      method: 'DELETE',
      redirect: 'error',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': `Bearer ${apiToken}`
      }
    });

    console.log('RESPONSE URL =', res.url, 'STATUS =', res.status);

    const data = await res.json().catch(() => ({}));

    if (!res.ok) {
      throw new Error(data.message || `Delete failed (${res.status})`);
    }

    el.closest('[data-applicant-row]')?.remove();
  } catch (err) {
    console.error('DELETE FAILED:', err);
    alert(err.message || 'Delete failed (see console).');
  }
}, true);
