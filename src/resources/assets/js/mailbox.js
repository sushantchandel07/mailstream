document.addEventListener("DOMContentLoaded", function () {
    const emailSubjects = document.querySelectorAll(".email-subject");
  
    emailSubjects.forEach((subject) => {
      subject.addEventListener("click", function (e) {
        const emailRecipientId = this.getAttribute("data-email-recipient-id");
  
        fetch(`/mark-as-read/${emailRecipientId}`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
            "Content-Type": "application/json",
          },
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              const parentLi = this.closest("li");
              parentLi.classList.remove("unread-email");
              parentLi.classList.add("read-email");
  
              const boldElement = this.querySelector("b");
              if (boldElement) {
                const textContent = boldElement.textContent;
                this.innerHTML = textContent;
              }
            }
          })
          .catch((error) => {
            console.error("Error marking email as read:", error);
          });
      });
    });
  });
  
  document.addEventListener("DOMContentLoaded", () => {
    const markAllUnreadBtn = document.getElementById("mark-all-unread");
    const markAsImportantBtn = document.getElementById("mark-as-important");
    const markAllReadBtn = document.getElementById("mark-all-read");
    const markAsSpam = document.getElementById("mark-as-spam");
    const markAsArchive = document.getElementById("mark-as-archive");
  
    function handleEmailAction(action) {
      const selectedEmails = Array.from(
        document.querySelectorAll(".email-checkbox:checked")
      ).map((checkbox) => checkbox.dataset.emailId);
  
      if (selectedEmails.length === 0) {
        alert("Please select at least one email.");
        return;
      }
  
      fetch("/emails/action", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify({
          email_ids: selectedEmails,
          action: action,
        }),
      })
        .then((response) => response.json())
        .then((data) => alert(data.message))
        .catch((error) => console.error("Error:", error));
    }
  
    if (markAllUnreadBtn) {
      markAllUnreadBtn.addEventListener("click", () =>
        handleEmailAction("mark_as_unread")
      );
    }
  
    if (markAsImportantBtn) {
      markAsImportantBtn.addEventListener("click", () =>
        handleEmailAction("mark_as_important")
      );
    }
  
    if (markAllReadBtn) {
      markAllReadBtn.addEventListener("click", () =>
        handleEmailAction("mark_as_read")
      );
    }
    if (markAsSpam) {
      markAsSpam.addEventListener("click", () =>
        handleEmailAction("mark_as_spam")
      );
    }
    if (markAsArchive) {
      markAsArchive.addEventListener("click", () =>
        handleEmailAction("mark_as_archive")
      );
    }
  });
  
  document
    .getElementById("trashButton")
    .addEventListener("click", function (event) {
      event.preventDefault();
      document.getElementById("formMethod").value = "POST";
      document.getElementById("ShowEmail").action = "/trash-email";
      document.getElementById("ShowEmail").submit();
    });
  
  document
    .getElementById("label-select")
    .addEventListener("change", function (e) {
      // Get the selected label ID
      const labelId = this.value;
  
      if (!labelId) {
        alert("Please select a valid label.");
        return;
      }
  
      // Collect all checked email IDs
      const checkedEmails = Array.from(
        document.querySelectorAll(".email-checkbox:checked")
      ).map((checkbox) => checkbox.dataset.emailId);
  
      if (checkedEmails.length === 0) {
        alert("Please select at least one email to label.");
        // Reset the dropdown
        this.selectedIndex = 0;
        return;
      }
  
      // Send the request to the server
      fetch("/emails/assign-label", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
        },
        body: JSON.stringify({
          mail_id: checkedEmails,
          label_id: labelId,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Emails labeled successfully.");
            // Optionally, refresh the page or update the UI
          } else {
            alert(data.message || "Failed to label emails.");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while labeling emails.");
        })
        .finally(() => {
          // Reset the dropdown after action
          this.selectedIndex = 0;
        });
    });
  
  document.querySelectorAll(".favourite-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const emailId = this.dataset.emailId;
      const isStarred = this.classList.contains("active") ? false : true;
  
      fetch(`/emails/${emailId}/toggle-star`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
            .content,
        },
        body: JSON.stringify({
          is_starred: isStarred,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.classList.toggle("active", isStarred);
          } else {
            alert("Failed to update star status");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while updating star status");
        });
    });
  });
  