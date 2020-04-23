# StoreCore.io photos and images


## Image dimensions

Add high-resolution photos in common sizes.  Use a suffix in the image
file name to indicate the image width and height.

| Size                | Use case   | Width | Height | Suffix       |
| ------------------- | ---------- | -----:| ------:| ------------ |
| 5K                  | Hero image |  5120 |   2880 | `-5120x2880` |
| 4K UHDTV            | Hero image |  3840 |   2160 | `-3840x2160` |
| Full HD (FHD)       | Hero image |  1920 |   1080 | `-1920x1080` |
| Wide XGA (WXGA)     | Hero image |  1366 |    768 | `-1366x768`  |
| JSON-LD metadata    | Metadata   |  1200 |   1200 | `-1200x1200` |
| JSON-LD metadata    | Metadata   |  1200 |    900 | `-1200x900`  |
| Open Graph metadata | Metadata   |  1200 |    675 | `-1200x675`  |
| 16:9 media card     | KB card    |  1056 |    594 | (none)       |

If the file size of a photo is to large at 4K (3840 by 2160 pixels), it MAY be
scaled down to 2K (2048 by 1080 pixels).


## Save the originals
Save a copy of the original photo at the highest possible resolution, preferably
without lossy compression to prevent image quality loss.  Add the suffix
`-original` as a reminder.
