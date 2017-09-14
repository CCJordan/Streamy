# Streamy

This is the work of less than an hour, so don't expect it to be feature complete.
A friend of mine wanted me to teach him KSP with Realism Overhaul and to judge his rocket designs. Twitch has a latency of approximately 12 seconds, which makes explaining things really annoying.

To find a faster solution, I used some commandline tools and a little php magic.

## Usage
I use ffmpeg to grab my screen and audio pack it and send it to my server.

macOS:

List your devices:

``ffmpeg -f avfoundation -list_devices true -i ""``

Stream from main monitor:

``ffmpeg -f dshow -f avfoundation -i 2:0 -preset fast -vcodec libx264 -tune zerolatency -f mpegts tcp://<<IP>>:12345``

Linux

``ffmpeg -f dshow -video_size 1920x1080 -f x11grab -i :0.0+0,0 -vcodec libx264 -tune zerolatency -b 900k -f mpegts tcp://<<IP>>:12345``

On the server I use nc to write the stream to a file in the same directory as the stream.php file:

``nc -l 12345 > mediaFile.mkv``

Of course you first have to open the port and start the stream after it.

Then the user can connect to the stream with https via https://hostname/stream.php, assuming the stream script is placed in the document root.

In our tests the latency was about 3 seconds.

## Disclaimer

As said, this is the work of a late evening and not supposed to handle a high amount of traffic and works fine for at least three people. We did not want to test more, because we had rockets to build.