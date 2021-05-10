     <div class="settings-area">
        <div
          class="settings-nav"
          itemscope
          itemtype="https://schema.org/ItemList"
        >
          <h1 class="account-settings">Account Settings</h1>
          <a href="#personal-info">Personal information</a>
          <a href="#pass-info">Password</a>
          <a href="#contact-info">Contact</a>
          <a href="#about-info">About</a>
          <button type="submit" class="submit-changes">Save Changes</button>
        </div>
        <div class="settings">
          <br id="personal-info" />
          <div class="personal-info">
            <h1 class="section-header">Personal information</h1>
            <div class="information">
              <form class="name-info">
                <div class="first-name-div">
                  <label
                    for="first-name-input"
                    class="first-name-label settings-label"
                    >First Name</label
                  >
                  <input
                    id="first-name-input"
                    name="first-name-input"
                    value="admin"
                  />
                </div>
                <div class="last-name-div">
                  <label
                    for="last-name-input"
                    class="last-name-label settings-label"
                    >Last Name</label
                  >
                  <input
                    id="last-name-input"
                    name="last-name-input"
                    value="admin"
                  />
                </div>
              </form>
              <form class="email-info">
                <div class="email-div">
                  <label for="email-input" class="email-label settings-label"
                    >Email Address</label
                  >
                  <input id="email-input" name="email-input" type="email" />
                </div>
              </form>
            </div>
          </div>
          <br id="pass-info" />
          <div class="pass-info">
            <h1 class="section-header">Password</h1>
            <div class="information">
              <form class="current-info">
                <div class="current-password-div">
                  <label
                    for="current-pass-input"
                    class="current-pass-label settings-label"
                    >Current Password</label
                  >
                  <input
                    type="password"
                    name="current-pass-input"
                    id="current-pass-input"
                  />
                </div>
              </form>

              <form class="password-info">
                <div class="password-div">
                  <label
                    for="password-input"
                    class="password-label settings-label"
                    >New Password</label
                  >
                  <input
                    type="password"
                    name="password-input"
                    id="password-input"
                  />
                </div>
                <div class="confirm-password-div">
                  <label
                    for="confirm-input"
                    class="confirm-label settings-label"
                    >Confirm Password</label
                  >
                  <input
                    type="password"
                    name="confirm-input"
                    id="confirm-input"
                  />
                </div>
              </form>
            </div>
          </div>
          <br id="contact-info" />
          <div class="contact-info">
            <h1 class="section-header">Contact</h1>
            <div class="information">
              <form class="contact-info-phone">
                <div class="phone-div">
                  <label for="phone-number" class="phone-label settings-label"
                    >Phone Number</label
                  >
                  <input type="tel" pattern="[0-9]{10}" name="phone-number" id="phone-number" />
                </div>
              </form>

              <form class="contact-info-address">
                <div class="address-div">
                  <label for="address" class="address-label settings-label"
                    >Address</label
                  >
                  <input name="address" id="address"/>
                </div>
              </form>
            </div>
          </div>
          <div class="about-info">
            <h1 class="section-header" id="about-info">About</h1>
            <div class="information">
              <form class="about-info-birthday">
                <div class="birthday-div">
                  <label for="birthday" class="birthday-label settings-label"
                    >Birthday</label
                  >
                  <input type="date" name="birthday" value="2000-11-11" id="birthday"/>
                </div>
              </form>

              <form class="about-info-description">
                <div class="description-div">
                  <label
                    for="description"
                    class="description-label settings-label"
                    >Description</label
                  >
                  <textarea id="description" name="description"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>