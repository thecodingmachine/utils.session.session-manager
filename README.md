<h1>The Session Manager</h1>

<p>The SessionManager package is in charge of managing the session for you.</p>

<h2>Why do we need a session manager?</h2>

<p>PHP offers a simple way to start sessions: the <a href="http://php.net/manual/function.session-start.php"><code>session_start</code></a> function.
So you would we ever need to use another session mechanism?</p>

<p>Well, sessions can be configured in a lot of different ways. You can use
<a href="http://php.net/manual/function.session_set_save_handler.php"><code>session_set_save_handler</code></a> to change completely 
the way sessions work. For instance, if you use Drupal, the sessions are stored in database. You could also configure your application
to use a special "session handler".</p>

<p>In Mouf, some components may need to access the session the way you do. So we decided to provide a simple way to initialize sessions.
As a bonus, the SessionManager offers a lot of settings for managing your session graphically.</p>

<h2>Using the session manager</h2>

<p>Just enable the package in your project. When the package is enabled, you have a <em>sessionManager</em> instance create.</p>

<p>To start a session, use:</p>
<pre>Mouf::getSessionManager()-gt;start();</pre>

<p>To write and close a session, use:</p>
<pre>Mouf::getSessionManager()-gt;write_close();</pre>

<p>To destroy a session, use:</p>
<pre>Mouf::getSessionManager()-gt;destroy();</pre>

<h2>The DefaultSessionManager class</h2>

<p>The DefaultSessionManager uses the standard PHP mechanism to track sessions. It offers a number of parameters to configure
the lifetime of a session, the path where session files are stored...</p>

<img src="defaultsessionmanager.png" alt="DefaultSessionManager" />